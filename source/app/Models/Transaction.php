<?php

namespace App\Models;

use DB;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

class Transaction extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'transaction';
    public $primaryKey = 'id';
    protected $fillable = ['t_id', 'username', 'cardtype_id', 'cardtype', 'card_number', 'amount', 'sms_amount', 'service_fee', 'low_fee', 'card_fee', 'card_holdername', 'phone', 'payment_method_id', 'payment_method', 'status', 'expiry_date', 'card_cvv', 'errorCode', 'memo', 'transaction_id', 'parent', 'child', 'rr_date', 'token', 'mid'];

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getList()
    {
        $arr_transaction = array();
        $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();

        return $list;
        /*foreach($list as $transaction)
            array_push($arr_transaction, self::getMoreDetail($transaction));
        return $arr_transaction;*/
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getAll($user = null, $shop_list = null)
    {
        $arr_transaction = array();

        $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();
                    
        foreach($list as $transaction){
            $newTransaction = self::getMoreDetail($transaction);
            if($user){

                // check name
                if($shop_list == null){
                    if($transaction->username == $user->name){
                        array_push($arr_transaction, $newTransaction);
                    }
                }
                else {

                    if(in_array($transaction->username, $shop_list))
                        array_push($arr_transaction, $newTransaction);
                }
            }
            else {
                array_push($arr_transaction, $newTransaction);
            }
        }

        return $arr_transaction;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getMoreDetail($transaction)
    {   
        // merchant, shop
        if($transaction->userType == '1'){
            $pay_cycle_id = 1;
            $transaction->merchant = Merchant::where('name', '=', $transaction->username)->first();
        }
        else {
            $transaction->shop = Shop::where('name', '=', $transaction->username)->first();
            $pay_cycle_id = $transaction->shop->s_paycycle_id;
            $transaction->merchant = Merchant::where('name', '=', $transaction->shop->member_id)->first();
        }
       
        // pay cycle
        $pay_cycle = PayCycle::findById($pay_cycle_id);
        $transaction->pay_cycle = $pay_cycle->name;
        return $transaction;
    }

     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

     public static function getAllByUser($start_date, $end_date, $user, $shop_list = null)
     {
        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        $arr_transaction = array();
        if($shop_list == null){
            $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                        ->join('users', 'transaction.username', '=', 'users.name')
                        ->where('transaction.created_at', '>=', $start_date)
                        ->where('transaction.created_at', '<=', $end_date)
                        ->where('transaction.username', $user->name)
                        ->orderBy('transaction.t_id', 'DESC')
                        ->orderBy('transaction.created_at', 'DESC')
                        ->get();
        }
        else {
            $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                        ->join('users', 'transaction.username', '=', 'users.name')
                        ->where('transaction.created_at', '>=', $start_date)
                        ->where('transaction.created_at', '<=', $end_date)
                        ->whereIn('transaction.username', $shop_list)
                        ->orderBy('transaction.t_id', 'DESC')
                        ->orderBy('transaction.created_at', 'DESC')
                        ->get();
        }
    
        foreach($list as $transaction)
            array_push($arr_transaction, self::getMoreDetail($transaction));
        return $arr_transaction;
     }
 
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public static function getSearch($params)
     {
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];
        $transaction_id = $params['transaction_id'];
        $t_id = $params['t_id'];
        $status = $params['status'];
        $card_number = $params['card_number'];
        $card_holder = $params['card_holder'];
        $tel = $params['tel'];
        $merchant_id = $params['merchant_id'];
        $shop_id = $params['shop_id'];
        $agency_name = $params['agency_name'];

        // filter dates
        if ($start_date == '')
            $start_date = '1900-01-01';
        if ($end_date == '')
            $end_date = '9999-01-01';

        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        // where
        $arr_where = array();
        array_push($arr_where, ['transaction.created_at', '>=', $start_date]);
        array_push($arr_where, ['transaction.created_at', '<=', $end_date]);
        if($transaction_id != '')
            array_push($arr_where, ['transaction.transaction_no', $transaction_id]);
        if($t_id != '')
            array_push($arr_where, ['transaction.t_id', substr($t_id,2)]);
        if($status != '')
            array_push($arr_where, ['transaction.status', $status]);
        if($card_number != '')
            array_push($arr_where, ['transaction.card_number', $card_number]);
        if($card_holder != '')
            array_push($arr_where, ['transaction.card_holdername', 'like', $card_holder]);
        if($tel != '')
            array_push($arr_where, ['transaction.phone', $tel]);

        if(($merchant_id != '') && ($shop_id != '')) {
            if($agency_name != '') {
                $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->join('shop', 'transaction.username', '=', 'shop.name')
                    ->where('shop.s_agency_name', '=', $agency_name)
                    ->whereIn('transaction.username', [$merchant_id, $shop_id])
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();
            }
            else {
                $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->where($arr_where)
                    ->whereIn('transaction.username', [$merchant_id, $shop_id])
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();
            }
        }
        else {
            if($merchant_id != '')
                array_push($arr_where, ['transaction.username', $merchant_id]);
            elseif($shop_id != '')
                array_push($arr_where, ['transaction.username', $shop_id]);

            if($agency_name != '') {
                $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->join('shop', 'transaction.username', '=', 'shop.name')
                    ->where('shop.s_agency_name', '=', $agency_name)
                    ->where($arr_where)
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();
            }
            else {
                $list = self::select('transaction.*', 'users.username as uname', 'users.type as userType')
                    ->join('users', 'transaction.username', '=', 'users.name')
                    ->where($arr_where)
                    ->orderBy('transaction.t_id', 'DESC')
                    ->orderBy('transaction.created_at', 'DESC')
                    ->get();
            }
            
        }       

        return $list;
     }

     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public static function getDetail($id)
     {
         $transaction = self::where('id', $id)->first();
         
         // merchant, shop
         $user = User::where('name', '=', $transaction->username)->first();
         if($user) {
             if($user->type == '1'){
                 $transaction->merchant = Merchant::where('name', '=', $transaction->username)->first();
                 $pay_cycle = PayCycle::findById(1);
             }
             else {
                 $transaction->shop = Shop::where('name', '=', $transaction->username)->first();
                 $transaction->merchant = Merchant::where('name', '=', $transaction->shop->member_id)->first();
                 $pay_cycle = PayCycle::findById($transaction->shop->s_paycycle_id);
             }
     
             // pay cycle
             $transaction->pay_cycle = $pay_cycle->name;
     
             // user type
             $transaction->userType = intval($user->type);
             return $transaction;
         }
 
         return null;
     }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function setRRDate()
    {
        $list = self::orderBy('t_id', 'DESC')->orderBy('created_at', 'DESC')->get();
        foreach($list as $transaction){
            $user = User::getUserByName($transaction->username);
            if($user != null){

                if($user->type != '1'){
                    $shop = Shop::getShopByName($user->name);
                    $pay_cycle = PayCycle::findById($shop->s_paycycle_id);

                    $rr_date = date('Y-m-d', strtotime($transaction->created_at . '+ 210 day'));
                    $rr_year = substr($rr_date,0,4);
                    $rr_month = substr($rr_date,5,2);
                    $rr_date = $rr_year . '-' . $rr_month . '-' . self::getMonthDates(intval($rr_year), intval($rr_month));

                    // check week end....
                    $week_day = date('N', strtotime($rr_date));
                    if($week_day == 7){
                        $rr_date = date('Y-m-d', strtotime($rr_date . ' +1 day'));
                    }
                    else if($week_day == 6){
                        $rr_date = date('Y-m-d', strtotime($rr_date . ' -1 day'));
                    }

                }
                else {
                    $rr_date = date('Y-m-d', strtotime('1999-01-01'));
                }

                $transaction = Transaction::findById($transaction->id);
                $transaction->rr_date = $rr_date;
                $transaction->save();
            }
        }
    }

    public static function getRRDate($paycycle_id)
    {
        if($paycycle_id > 2){

            $rr_date = date('Y-m-d', strtotime('+ 210 day'));
            $rr_year = substr($rr_date,0,4);
            $rr_month = substr($rr_date,5,2);
            $rr_date = $rr_year . '-' . $rr_month . '-' . self::getMonthDates(intval($rr_year), intval($rr_month));

            // check week end....
            $week_day = date('N', strtotime($rr_date));
            if($week_day == 7){
                $rr_date = date('Y-m-d', strtotime($rr_date . ' +1 day'));
            }
            else if($week_day == 6){
                $rr_date = date('Y-m-d', strtotime($rr_date . ' -1 day'));
            }

        }
        else {
            $rr_date = date('Y-m-d', strtotime('1999-01-01'));
        }

        return $rr_date;
    }

    public static function getMonthDates($year, $month)
    {
        $arr_date_max = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if($month == 2){
            if($year % 4 == 0)
                return 29;
        }

        return $arr_date_max[$month-1];
    }


    public static function getRRAmount($output_date, $user)
    {
        $output_date = str_replace('年', '-', str_replace('日', '', str_replace('月', '-', $output_date)));
        $invoice = self::select(DB::raw('sum(amount) as amount'))
                    ->where('username', $user->name)
                    ->where('rr_date', $output_date)
                    ->where('status', '成功')
                    ->first();
        if($invoice)
            return ceil($invoice->amount * 0.05);
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getLastId()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'tb_transaction'");
        return $statement[0]->Auto_increment;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function checkCard($card_id, $transaction){

        if($card_id != -1){
            if($card_id != $transaction->cardtype_id)
                return false;
        }

        return true;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function getTotalCount($list, $status, $card_id = -1)
    {
        $total = 0;
        foreach($list as $transaction){

            if($status == ''){
                if(self::checkCard($card_id, $transaction))
                    $total++;
            }
            else  {
                if($transaction->status == $status){
                    if(self::checkCard($card_id, $transaction))
                        $total++;
                }
            }
        }

        return $total;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public static function getTotalAmount($list, $status, $card_id = -1)
     {
         $totalAmount = 0;
         foreach($list as $transaction){
 
             if($status == ''){
                 if(self::checkCard($card_id, $transaction))
                     $totalAmount += $transaction->amount;
             }
             else {
                 if($transaction->status == $status){
                     if(self::checkCard($card_id, $transaction))
                         $totalAmount += $transaction->amount;
                 }
             }
         }
 
         return $totalAmount;
     }
 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function getCountByUser($start_date, $end_date, $user)
    {
        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        return self::where('username', $user->name)
                    ->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date)
                    ->count();
    }
 
    public static function getAllCount($start_date, $end_date, $user, $status, $card_id = -1)
    {
        $start_date .= ' 00:00';
        $end_date .= ' 23:59';
        $arr_where = array();

        if($status != '')
            array_push($arr_where, ['status', $status]);
        array_push($arr_where, ['username', $user->name]);
        array_push($arr_where, ['cardtype_id', $card_id]);
        
        return self::where($arr_where)
                    ->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date)
                    ->count();
    }

    public static function getAllAmount($start_date, $end_date, $user, $status, $card_id = -1)
    {
        $start_date .= ' 00:00';
        $end_date .= ' 23:59';
        $arr_where = array();

        if($status != '')
            array_push($arr_where, ['status', $status]);
        array_push($arr_where, ['username', $user->name]);
        array_push($arr_where, ['cardtype_id', $card_id]);
        
        $total = self::select(DB::raw('sum(amount) as amount'))
                    ->where($arr_where)
                    ->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date)
                    ->get();

        if($total[0]->amount)
            return $total[0]->amount;
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function getSMSCountByCard($user, $card_id)
    {
        return self::where('payment_method', 'SMS決済')
                    ->where('username', $user->name)
                    ->where('status', '成功')
                    ->where('cardtype_id', $card_id)
                    ->count();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function checkToken($token)
    {
        $transaction = self::where('token', $token)->first();
        if($transaction != null)
            return true;
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       
    public static function getDataByUser($start_date, $end_date, $user, $data)
    {
        $data = self::initData($data);

        // get
        $start_date .= ' 00:00';
        $end_date .= ' 23:59';
        $arr_where = array();

        $ret = self::select(DB::raw('count(cardtype_id) as count'), DB::raw('sum(amount) as amount'), 'status', 'cardtype_id')
                    ->where('username', $user->name)
                    ->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date)
                    ->groupBy('status')
                    ->groupBy('cardtype_id')
                    ->get();

        if(sizeof($ret) > 0) {
            foreach($ret as $info) {

                if(($info->status == '成功') && ($info->cardtype_id == 1)) {                // 成功
                    $data['v_count'] = $info->count;
                    $data['v_amount'] = $info->amount;
                }
                elseif(($info->status == '成功') && ($info->cardtype_id == 2)) {
                    $data['m_count'] = $info->count;
                    $data['m_amount'] = $info->amount;
                }
                elseif(($info->status == '成功') && ($info->cardtype_id == 3)) {
                    $data['j_count'] = $info->count;
                    $data['j_amount'] = $info->amount;
                }
                elseif(($info->status == '成功') && ($info->cardtype_id == 4)) {
                    $data['a_count'] = $info->count;
                    $data['a_amount'] = $info->amount;
                }
                elseif(($info->status == '返金完了') && ($info->cardtype_id == 1)) {        // 返金完了
                    $data['v_cc_count'] = $info->count;
                    $data['v_cc_amount'] = $info->amount;
                }
                elseif(($info->status == '返金完了') && ($info->cardtype_id == 2)) {
                    $data['m_cc_count'] = $info->count;
                    $data['m_cc_amount'] = $info->amount;
                }
                elseif(($info->status == '返金完了') && ($info->cardtype_id == 3)) {
                    $data['j_cc_count'] = $info->count;
                    $data['j_cc_amount'] = $info->amount;
                }
                elseif(($info->status == '返金完了') && ($info->cardtype_id == 4)) {
                    $data['a_cc_count'] = $info->count;
                    $data['a_cc_amount'] = $info->amount;
                }
                elseif(($info->status == 'CB確定') && ($info->cardtype_id == 1)) {          // CB確定
                    $data['v_cb_count'] = $info->count;
                    $data['v_cb_amount'] = $info->amount;
                }
                elseif(($info->status == 'CB確定') && ($info->cardtype_id == 2)) {
                    $data['m_cb_count'] = $info->count;
                    $data['m_cb_amount'] = $info->amount;
                }
                elseif(($info->status == 'CB確定') && ($info->cardtype_id == 3)) {
                    $data['j_cb_count'] = $info->count;
                    $data['j_cb_amount'] = $info->amount;
                }
                elseif(($info->status == 'CB確定') && ($info->cardtype_id == 4)) {
                    $data['a_cb_count'] = $info->count;
                    $data['a_cb_amount'] = $info->amount;
                }
            }
        }
      
        return $data;
    }

    public static function initData($data)
    {
        // 成功
        $data['v_count'] = 0;
        $data['m_count'] = 0;
        $data['j_count'] = 0;
        $data['a_count'] = 0;

        $data['v_amount'] = 0;
        $data['m_amount'] = 0;
        $data['j_amount'] = 0;
        $data['a_amount'] = 0;

        // 返金完了
        $data['v_cc_count'] = 0;
        $data['m_cc_count'] = 0;
        $data['j_cc_count'] = 0;
        $data['a_cc_count'] = 0;

        $data['v_cc_amount'] = 0;
        $data['m_cc_amount'] = 0;
        $data['j_cc_amount'] = 0;
        $data['a_cc_amount'] = 0;

        // CB確定
        $data['v_cb_count'] = 0;
        $data['m_cb_count'] = 0;
        $data['j_cb_count'] = 0;
        $data['a_cb_count'] = 0;

        $data['v_cb_amount'] = 0;
        $data['m_cb_amount'] = 0;
        $data['j_cb_amount'] = 0;
        $data['a_cb_amount'] = 0;    

        return $data;
    }
}
