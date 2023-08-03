<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/20/2018
 * Time: 11:48 AM
 */
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App;
use DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\Setting;
use DateTime;
use DateInterval;
use App\Models\SMS;
use App\Models\Mailer;
use App\Models\Merchant;
use App\Models\PayCycle;
use App\Models\CardType;
use App\Models\PaymentMethod;
use App\Models\Mid;
use Twilio\Options;

class PaymentController extends CustomerController
{
    protected $platform = 'customer';

    public function index($path)
    {
        Session::put('menu', 'home');

        // check path error
        $data = $this->getShopInfo($path);
        if($data == null)
            return redirect('/');

        // check if status of shop is available.
        $user_status = User::getUserStatus($data['name']);
        $this->view_datas['status'] = $user_status;
        $this->view_datas['name'] = $data['name'];
        $this->view_datas['m_name'] = $data['m_name'];
        $this->view_datas['payment_method_id'] = $data['payment_method_id'];
        $this->view_datas['phone'] = $data['phone'];

        // Fee
        $this->view_datas['visa_fee'] = $this->getMerchantFee($data['name'], 1) + $this->getLowFee($data['name'], 1);
        $this->view_datas['master_fee'] = $this->getMerchantFee($data['name'], 2) + $this->getLowFee($data['name'], 2);
        $this->view_datas['jcb_fee'] = $this->getMerchantFee($data['name'], 3) + $this->getLowFee($data['name'], 3);
        $this->view_datas['amex_fee'] = $this->getMerchantFee($data['name'], 4) + $this->getLowFee($data['name'], 4);

        //トークン発行
        $payment_token = $this->generateToken(64);
        $this->view_datas['payment_token'] = $payment_token;

        // create session with token for time limit.
        Session::put($payment_token, time());
        //Session::save();

        return view("{$this->platform}.payment.index",  ['datas' => $this->view_datas]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Payment Confirm
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function confirm(Request $request)
    {
        $params = $request->all();

        // card type
        if(!isset($params['cardtype_id']) || ($params['cardtype_id'] == ''))
            $params['cardtype_id'] = 1;

        // amount
        $amount = floatval($params['amount']);
        $params['service_amount'] = $amount;

        $amount += ($amount * floatval($params['fee'])) / 100;
        //$sms_amount = ($params['payment_method_id'] == 3) ? 20: 0;
        $params['amount'] = $amount; // + $sms_amount;

        if($params['email'] == null){
            $params['email'] = '';
        }

        $this->view_datas['data'] = $params;
        return view("{$this->platform}.payment.confirm",  ['datas' => $this->view_datas]);
    }

    function generateToken($length){
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Create Payment
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function postCreate(Request $request)
    {
        try {

            $params = $request->all();

            // payment method id
            $payment_method_id = $params['payment_method_id'];

            // card number
            $params['card_number'] = str_replace(' ', '', $params['card_number']);

            // get token
            $payment_token = $params['payment_token'];

            // transaction number
            $transaction_id = '';

            // check if popup or direct payment
            if($params['payment_direct'] == 1) {

                // direct payment (from banner url) 
                $token_create_time = (int)Session::get($payment_token);
                $current_time = time();
                $diff_time = $current_time - $token_create_time;

                // session_time_limit into tb_setting
                $session_time_limit = (int)Setting::getSessionTimeLimit();
                if($session_time_limit * 60 < $diff_time){

                    $params['return_code'] = '9998';
                    $this->view_datas['data'] = (object)$params;
                    $this->view_datas['payment_method_id'] = $payment_method_id;
                    return view("{$this->platform}.payment.thanks",  ['datas' => $this->view_datas]);
                }
            }

            // check token in db
            if(!Transaction::checkToken($params['payment_token'])) {

                //check payment token in session.       
                $token_list = array();
                if (Session::get('payment_tokens') != NULL){
                    $token_list = Session::get('payment_tokens');
                }

                if (!in_array($payment_token, $token_list))
                {
                    array_push($token_list, $payment_token);
                    Session::put('payment_tokens', $token_list);
                    //Session::save();
                    
                    // create Transaction
                    $transaction = $this->createTransaction($params);
                    $params['amount'] = intval($transaction->amount);
                    $params['mid'] = $transaction->mid; 

                    // create Payment
                    $result = $this->createPayment($params);
                    if ($result) {

                        // save transaction
                        $data = json_decode($result);
                        if($data->return_code == '0000') {
                            $transaction->status = '成功';
                            $transaction->transaction_no = $data->transaction_no;
                            $transaction_id = $data->transaction_no;
                        }
                        else {
                            $transaction->status = '失敗';
                            $transaction->transaction_no = '';
                        }

                        $transaction->errorCode = $data->return_code;
                        $transaction->save();

                        // send email to user
                        if($params['email'] != '') {
                            $to = $params['email'];
                            Mailer::sendPaymentEmail($to, $params, $data->return_code);
                        }

                        // send email to shop or merchant
                        $user = User::getUserInfoByName($params['name']); 
                        if($user->type == '1'){
                            $merchant = Merchant::getUserByName($params['name']);
                            Mailer::sendPaymentEmail($merchant->u_email, $params, $data->return_code);
                        }
                        else {
                            $shop = Shop::getShopByName($params['name']);
                            Mailer::sendPaymentEmail($shop->s_email, $params, $data->return_code);
                        }

                        // success
                        $data->amount = $params['amount'];
                        $data->card_number = $params['card_number'];
                        $data->card_holder = $params['card_holder'];
                        $data->phone = $params['cellphone'];

                        $this->view_datas['data'] = $data;
                        $this->view_datas['payment_method_id'] = $payment_method_id;
                        return view("{$this->platform}.payment.thanks",  ['datas' => $this->view_datas]);
                    }
                }
            }

            // Fail
            $params['return_code'] = '9999';
            $this->view_datas['data'] = (object)$params;
            $this->view_datas['payment_method_id'] = $payment_method_id;
            return view("{$this->platform}.payment.thanks",  ['datas' => $this->view_datas]);
            
        } catch (\Exception $e) {

            // call slackAPI
            $message = $e->getMessage() . '&IP=' . $this->getClientIP() . '&transaction_id=' . $transaction_id . '&card_name=' . $params['card_holder'] . '&phone_number=' . $params['cellphone']; 
            $this->sendSlackMessage($message);
            
            // exception
            $params['return_code'] = '8001';
            $this->view_datas['data'] = (object)$params;
            $this->view_datas['payment_method_id'] = $payment_method_id;
            return view("{$this->platform}.payment.thanks",  ['datas' => $this->view_datas]);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Get Client IP
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getClientIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Send Slack Message
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function sendSlackMessage($message)
    {
        $headers = [
            'Authorization: Bearer xoxb-899558306371-3458909411011-rLRgcWM0ZYJmJXuEOkdXl6V9',
            'Content-Type: application/json;charset=utf-8'
        ];

        $channel = '#message';
        $url = "https://slack.com/api/chat.postMessage";
        $post_fields = [
            "channel" => $channel,
            "text" => $message,
            "as_user" => true
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_fields) 
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Create Payment
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function createPayment($params)
    {
        // get mid
        $mid = Mid::findOrFail($params['mid']);
        $merchant_key = $mid->merchant_key;         //'S68ECF';
        $user_id = $mid->user_id;                   // 99;
        $auth_key = $mid->mid;                      //'02BCF67D08B3183C06E53A651A08298442E7BA16';       

        // amount
        $amount = intval($params['amount']) * 100;

        // deadline
        $now_date = new DateTime();
        $now_date->add(new DateInterval('PT' . 10 . 'M'));
        $deadline = $now_date->getTimestamp(); 

        // unique_order_id
        $code = Transaction::getLastId() + 10001;
        $unique_order_id = $this->generateToken(16);

        // payment url
        $str_url = '//gateway.s-paysystem.com/A/' . $merchant_key . '/' . $user_id . '/' . $unique_order_id . '/JPY/' . $amount . '/' . $deadline . '/PAYMENT.DO';
        $v = md5($auth_key . strtoupper($str_url));
        $payment_url = 'https:' . $str_url . '?V=' . $v;

        // curl
        $ch = curl_init($payment_url);

        $options = array(
            'METHOD' => 'PURCHASE',
            'CELLPHONE' => $params['cellphone'],
            'CARD_HOLDER' => $params['card_holder'],
            'CARD_NUMBER'=> $params['card_number'],
            'EXPIRY_MONTH'=> $params['expiry_month'],
            'EXPIRY_YEAR'=> $params['expiry_year'],
            'CVV'=> $params['cvv'],
        );

        if (Setting::sendPaymentToken() == '1'){
            $options['NOTE'] = $params['payment_token'];
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($options));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // result
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Create Transaction
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function createTransaction($params)
    {
        // save transaction
        $transaction = new Transaction();
        $transaction->t_id = Transaction::getLastId();
        $transaction->username = $params['name'];
        $transaction->cardtype_id = intval($params['cardtype_id']);

        // card type
        $cardtype = CardType::findById($transaction->cardtype_id);
        $transaction->cardtype = $cardtype->name;

        $transaction->card_number = $params['card_number'];
        $transaction->expiry_date = $params['card_exp_year'] . '/' . $params['expiry_month'];
        $transaction->card_cvv = $params['cvv'];
        $transaction->amount = $params['amount'];
        $transaction->sms_amount = ($params['payment_method_id'] == 3) ? 20: 0;
        $transaction->card_holdername = $params['card_holder'];
        $transaction->phone = $params['cellphone'];
        $transaction->payment_method_id = $params['payment_method_id'];

        // payment method
        $payment_method = PaymentMethod::findById($transaction->payment_method_id);
        $transaction->payment_method = $payment_method->name;
        $transaction->service_fee = $params['service_amount'];
        $transaction->low_fee = $this->getLowFee($transaction->username, $transaction->cardtype_id);
        $transaction->card_fee = $this->getMerchantFee($transaction->username, $transaction->cardtype_id);
        $transaction->memo = '';
        $transaction->token = $params['payment_token'];
        $transaction->created_at = date('Y-m-d H:i:s');
        $transaction->updated_at = date('Y-m-d H:i:s');

        // pay_cycle
        $pay_cycle = PayCycle::findById(1);
        $user = User::getUserInfoByName($params['name']);
        if($user->type != '1'){
            $shop = Shop::getShopByName($user->name);
            $pay_cycle = PayCycle::findById($shop->s_paycycle_id);
            $transaction->mid = $shop->mid;
        }
        else {
            $transaction->mid = 1;
        }

        $transaction->rr_date = Transaction::getRRDate($pay_cycle->id);
        return $transaction;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Get Information from Merchant or Shop
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getShopInfo($path)
    {
        // analysis the path
        $data = null;

        $path = str_replace('&amp;', '&', $path);
        $arr_path = explode('&', $path);

        if(sizeof($arr_path) > 1){

            $type = str_replace('s=', '', $arr_path[0]);                // s: merchant, shop
            $name = str_replace('p=', '', $arr_path[1]);                // p: name
            $payment_method_id = str_replace('m=', '', $arr_path[2]);   // m: 1 banner payment, 2 QR,  3 SMS
            $phone = '';

            // get phone number when SMS payment
            if(sizeof($arr_path) > 3)
                $phone = str_replace('n=', '', $arr_path[3]);

            if(($type != '') && ($name != '') && ($payment_method_id != ''))
            {
                if($type == 'merchant'){
                    $merchant = Merchant::getUserByName($name);
                    if($merchant != null){
                        $data = array('type' =>$type, 'name'=>$name, 'm_name' =>$merchant->u_name, 'payment_method_id' => $payment_method_id, 'phone' => $phone);
                    }
                }
                else {
                    $shop = Shop::getShopByName($name);
                    if($shop != null){
                        $data = array('type' =>$type, 'name'=>$name,'m_name' =>$shop->s_name, 'payment_method_id' => $payment_method_id, 'phone' => $phone);
                    }
                }
            }
        }

        return $data;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Get Information from Merchant or Shop
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getUserEmailByName($username)
    {
        $user = User::getUserByName($username);
        if($user->type == '1'){
            $merchant = Merchant::getUserByName($username);
            return $merchant->u_email;
        }

        $shop = Shop::getShopByName($username);
        return $shop->s_email;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Get Card Fee from Merchant or Shop
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getMerchantFee($username, $card_type)
    {
        $user = User::getUserByName($username);
        if($user->type == '1'){
            $merchant = Merchant::getUserByName($username);

            switch($card_type){
                case 1:
                    return floatval($merchant->u_visa_fee);

                case 2:
                    return floatval($merchant->u_master_fee);

                case 3:
                    return floatval($merchant->u_jcb_fee);

                case 4:
                    return floatval($merchant->u_amex_fee);
            }
        }

        $shop = Shop::getShopByName($username);
        switch($card_type){
            case 1:
                return floatval($shop->sm_visa_fee);

            case 2:
                return floatval($shop->sm_master_fee);

            case 3:
                return floatval($shop->sm_jcb_fee);

            case 4:
                return floatval($shop->sm_amex_fee);
        }
    }

    public function getLowFee($username, $card_type)
    {
        $user = User::getUserByName($username);
        if($user->type == '1'){

            $merchant = Merchant::getUserByName($username);
            switch($card_type){
                case 1:
                    return floatval($merchant->u_visa_fee_low);

                case 2:
                    return floatval($merchant->u_master_fee_low);

                case 3:
                    return floatval($merchant->u_jcb_fee_low);

                case 4:
                    return floatval($merchant->u_amex_fee_low);
            }
        }
        else {

            $shop = Shop::getShopByName($username);
            switch($card_type){
                case 1:
                    return floatval($shop->s_visa_fee);

                case 2:
                    return floatval($shop->s_master_fee);

                case 3:
                    return floatval($shop->s_jcb_fee);

                case 4:
                    return floatval($shop->s_amex_fee);
            }
        }
    }

}