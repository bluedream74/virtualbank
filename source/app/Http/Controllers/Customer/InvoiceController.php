<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/20/2018
 * Time: 11:48 AM
 */
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Session;
use App;
use DateTime;
use DateTimeZone;
use App\Models\PayCycle;
use App\Models\Shop;
use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Invoice;
use App\Models\BreakDates;
use App\Models\Setting;

class InvoiceController extends CustomerController
{
    protected $platform = 'customer';

    public function index($token)
    {
        Session::put('menu', 'invoice');
        
        $remember_token = str_replace('/', '', Auth::user()->remember_token); 
        if($token != $remember_token){
            return redirect('/');
        }

        if(session('invoice_date'))
            $invoice_date = session('invoice_date');
        else
            $invoice_date = date('Y-m', strtotime(Setting::getToday()));

        $this->view_datas['date'] = $invoice_date;
        $this->view_datas['list'] = $this->getInvoices($invoice_date);
        return view("{$this->platform}.invoice.index",  ['datas' => $this->view_datas]);
    }

    // post create
    public function postCreate(Request $request)
    {
        $params = $request->all();
        if(!isset($params['shop_id'])){
            $params['shop_id'] = '';
            $params['shop_name'] = '';
        }

        // invoice
        $invoice = new Invoice();
        $invoice->fill($params);
        $invoice->save();

        return redirect('/invoice/' . Auth::user()->getRememberToken());
    }

    // search
    public function postSearch(Request $request)
    {
        $params = $request->all();
        return redirect('/invoice/' . Auth::user()->getRememberToken())->with(['invoice_date' => $params['month']]);
    }

    // detail
    public function getDetail($year, $start, $end, $output_date, $is_lastdate)
    {
        $this->view_datas['year'] = $year;
        $this->view_datas['start'] = $start;
        $this->view_datas['end'] = $end;
        $this->view_datas['output_date'] = $output_date;

        if(Auth::user()->type == '1'){
            $merchant =  Merchant::getUserByName(Auth::user()->name);
            $this->view_datas['merchant_name'] = $merchant->u_name;
            $this->view_datas['merchant_id'] = $merchant->name;
            $this->view_datas['shop_name'] = '';
            $this->view_datas['shop_id'] = '';
        }
        else {
            $shop = Shop::getShopByName(Auth::user()->name);
            $merchant =  Merchant::getUserByName($shop->member_id);
            $this->view_datas['merchant_name'] = $merchant->u_name;
            $this->view_datas['merchant_id'] = $merchant->name;
            $this->view_datas['shop_name'] = $shop->s_name;
            $this->view_datas['shop_id'] = $shop->name;
        }

        $this->view_datas['last_invoice'] = Invoice::getLastInvoice($this->view_datas);

        // start, end date
        $start_date = $year . '-' . str_replace('日', '', str_replace('月', '-', $start));
        $end_date = $year . '-' . str_replace('日', '', str_replace('月', '-', $end));

        // transaction list
        $user = Auth::user();
        $this->view_datas['transaction_count'] = Transaction::getCountByUser($start_date, $end_date, Auth::user());
        $this->view_datas['visa_count'] = Transaction::getAllCount($start_date, $end_date, $user, '', 1);
        $this->view_datas['master_count'] = Transaction::getAllCount($start_date, $end_date, $user, '', 2);
        $this->view_datas['jcb_count'] = Transaction::getAllCount($start_date, $end_date, $user, '', 3);
        $this->view_datas['amex_count'] = Transaction::getAllCount($start_date, $end_date, $user, '', 4);

        $this->view_datas['visa_ss_count'] = Transaction::getAllCount($start_date, $end_date, $user, '成功', 1);
        $this->view_datas['visa_ss_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '成功', 1);
        $this->view_datas['master_ss_count'] = Transaction::getAllCount($start_date, $end_date, $user, '成功', 2);
        $this->view_datas['master_ss_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '成功', 2);
        $this->view_datas['jcb_ss_count'] = Transaction::getAllCount($start_date, $end_date, $user, '成功', 3);
        $this->view_datas['jcb_ss_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '成功', 3);
        $this->view_datas['amex_ss_count'] = Transaction::getAllCount($start_date, $end_date, $user, '成功', 4);
        $this->view_datas['amex_ss_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '成功', 4);

        $this->view_datas['visa_cc_count'] = Transaction::getAllCount($start_date, $end_date, $user, '返金完了', 1);
        $this->view_datas['visa_cc_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '返金完了', 1);
        $this->view_datas['master_cc_count'] = Transaction::getAllCount($start_date, $end_date, $user, '返金完了', 2);
        $this->view_datas['master_cc_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '返金完了', 2);
        $this->view_datas['jcb_cc_count'] = Transaction::getAllCount($start_date, $end_date, $user, '返金完了', 3);
        $this->view_datas['jcb_cc_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '返金完了', 3);
        $this->view_datas['amex_cc_count'] = Transaction::getAllCount($start_date, $end_date, $user, '返金完了', 4);
        $this->view_datas['amex_cc_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, '返金完了', 4);

        $this->view_datas['visa_cb_count'] = Transaction::getAllCount($start_date, $end_date, $user, 'CB確定', 1);
        $this->view_datas['visa_cb_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, 'CB確定', 1);
        $this->view_datas['master_cb_count'] = Transaction::getAllCount($start_date, $end_date, $user, 'CB確定', 2);
        $this->view_datas['master_cb_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, 'CB確定', 2);
        $this->view_datas['jcb_cb_count'] = Transaction::getAllCount($start_date, $end_date, $user, 'CB確定', 3);
        $this->view_datas['jcb_cb_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, 'CB確定', 3);
        $this->view_datas['amex_cb_count'] = Transaction::getAllCount($start_date, $end_date, $user, 'CB確定', 4);
        $this->view_datas['amex_cb_amount'] = Transaction::getAllAmount($start_date, $end_date, $user, 'CB確定', 4);

        // sms transaction count by card id
        $this->view_datas['visa_sms_count'] = Transaction::getSMSCountByCard($user, 1);
        $this->view_datas['master_sms_count'] = Transaction::getSMSCountByCard($user, 2);
        $this->view_datas['jcb_sms_count'] = Transaction::getSMSCountByCard($user, 3);
        $this->view_datas['amex_sms_count'] = Transaction::getSMSCountByCard($user, 4);

        // card fee
        $this->view_datas['visa_fee'] = $this->getMerchantFee(Auth::user()->name, 1);
        $this->view_datas['master_fee'] = $this->getMerchantFee(Auth::user()->name, 2);
        $this->view_datas['jcb_fee'] = $this->getMerchantFee(Auth::user()->name, 3);
        $this->view_datas['amex_fee'] = $this->getMerchantFee(Auth::user()->name, 4);

        $this->view_datas['visa_low_fee'] = $this->getLowFee(Auth::user()->name, 1);
        $this->view_datas['master_low_fee'] = $this->getLowFee(Auth::user()->name, 2);
        $this->view_datas['jcb_low_fee'] = $this->getLowFee(Auth::user()->name, 3);
        $this->view_datas['amex_low_fee'] = $this->getLowFee(Auth::user()->name, 4);

        //  RR payment period
        $total = ceil($this->view_datas['visa_ss_amount']);
        $total += ceil($this->view_datas['master_ss_amount']);
        $total += ceil($this->view_datas['jcb_ss_amount']);
        $total += ceil($this->view_datas['amex_ss_amount']);
        $rr_payment_amount = ceil($total * 0.05);

        $this->view_datas['rr_start_date'] = $output_date;
        $this->view_datas['rr_invoice_amount'] = Transaction::getRRAmount($output_date, Auth::user());
        $this->view_datas['rr_payment_amount'] = $rr_payment_amount;

        // cancel fee
        $this->view_datas['cancel_fee'] = 300;
        $this->view_datas['enter_fee'] = 500;

        if(Auth::user()->type == '2'){
            $shop = Shop::getShopByName(Auth::user()->name);
            $this->view_datas['cancel_fee'] = $shop->s_cancel_fee;
            $this->view_datas['enter_fee'] = $shop->s_enter_fee;
        }

        // pay_cycle
        if(Auth::user()->type == '1'){
            $pay_cycle = PayCycle::findById(1);
        }
        else {
            $shop = Shop::getShopByName(Auth::user()->name);
            $pay_cycle = PayCycle::findById($shop->s_paycycle_id);
        }

        $this->view_datas['pay_cycle'] = $pay_cycle->id;

        // monthly fee
        $this->view_datas['month_fee'] = 0;
        if($is_lastdate == 1)
            $this->view_datas['month_fee'] = $this->getMonthFee($pay_cycle->id, $total, $year, $end);

        $invoice_id = Invoice::checkInvoice($this->view_datas, $start_date, $end_date);
        if($invoice_id != 0){
            $invoice = Invoice::getDetail($invoice_id);
            $this->view_datas['merchant_username'] = $invoice->merchant_username;
        }
        else {
            $this->view_datas['merchant_username'] = '';
        }

        $this->view_datas['Invoiced'] = $invoice_id; 
        $this->view_datas['order_date'] = date('Y年m月d日', strtotime('+ 1 day ' . $end_date)); //$this->getOrderDate($start_date, $pay_cycle->id);
        return view("{$this->platform}.invoice.detail",  ['datas' => $this->view_datas]);
    }

    // get order date
    public function getOrderDate($start_date, $pay_cycle_id)
    {
        switch($pay_cycle_id){
            case 1:
                return date('Y年m月d日', strtotime('last day of +1 month' . $start_date));
            case 2:

                $invoice_startDate = intval(date('d', strtotime($start_date)));
                $start_date = date('Y-m-d', strtotime('+1 month' . $start_date));

                if($invoice_startDate == 1)
                    return date('Y年m月d日', strtotime($start_date . '+14 days'));

                return date('Y年m月d日', strtotime('last day of this month ' . $start_date));

            case 3:
                return date('Y年m月d日', strtotime($start_date . '+8 days'));

            case 4:
                return date('Y年m月d日', strtotime($start_date . '+2 days'));
        }
    }

    public function getMerchantFee($username, $card_type)
    {
        $user = User::getUserInfoByName($username);
        if($user->type == '1'){
            $merchant = Merchant::getUserInfoByName($username);
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

        // shop
        $shop = Shop::getShopInfoByName($username);
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
        $user = User::getUserInfoByName($username);
        if($user->type == '1'){

            $merchant = Merchant::getUserInfoByName($username);
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

            $shop = Shop::getShopInfoByName($username);
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

    public function getMonthFee($paycycle_id, $total, $year, $end_date)
    {
        if($paycycle_id < 3){
            if($total >= 300000)
                return 3000;
            elseif(($total >= 100000) && ($total < 300000))
                return 1500;
            else
                return 0;
        }

        return 3000;
    }

    // get Invoices
    public function getInvoices($invoice_date)
    {
        // pay_cycle
        $user = Auth::user();
        if($user->type == '1'){
            $pay_cycle = PayCycle::findById(1);
        }
        else {
            $shop = Shop::getShopByName($user->name);
            $pay_cycle = PayCycle::findById($shop->s_paycycle_id);
        }

        // year, month, dates
        $year = substr($invoice_date, 0, 4);
        $month = intval(substr($invoice_date, 5, 2));
        $dates = $this->getMonthDates($year, $month);

        $current_year = $year; //date('Y', strtotime(Setting::getToday()));
        $current_month = $month; //date('m', strtotime(Setting::getToday()));
        $current_dates = $dates; //$this->getMonthDates($year, $month);

        // invoice
        $arr_invoice = array();
        switch($pay_cycle->id){
            case 1:             // 月1支払い

                $start_date = $month . '月1日';
                $end_date = $month . '月' . $dates . '日';
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = $current_year . '-' . $current_month . '-' . $current_dates;
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);

                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);
                array_push($arr_invoice, $invoice);
                break;

            case 2:             // 月2支払い

                // 15日
                $start_date = $month . '月1日';
                $end_date = $month . '月15日';
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = $current_year . '-' . $current_month . '-15';
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);
                array_push($arr_invoice, $invoice);

                // last date
                $start_date = $month . '月16日';
                $end_date = $month . '月' . $this->getMonthDates($year, $month) . '日';
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = $current_year . '-' . $current_month . '-' . $current_dates;
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);
                array_push($arr_invoice, $invoice);

                break;

            case 3:             // 週１支払い

                $first_monday = date("Y-m-d", strtotime("first monday " . $year . '-' . $month));
                $first_monday_date = date("d", strtotime("first monday " . $year . '-' . $month));
                if($first_monday_date == 8){
                    $first_monday = date("Y-m-d", strtotime("-7 days " . $first_monday));
                }

                // 1st week
                $start_date = date("m月d日", strtotime($first_monday));
                $end_date = date("m月d日", strtotime("+ 6 days " . $first_monday));
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = date("Y-m-d", strtotime("+ 8 days " . $first_monday));
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);
                array_push($arr_invoice, $invoice);

                // second week
                $start_date = date("m月d日", strtotime("+ 7 days "  . $first_monday));
                $end_date = date("m月d日", strtotime("+ 13 days " . $first_monday));
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = date("Y-m-d", strtotime("+ 15 days " . $first_monday));
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);

                // check if last invoice of this month
                $end_date_current_month = date("m", strtotime("+ 7 days " . $first_monday));
                $end_date_month = date("m", strtotime("+ 22 days " . $first_monday));
                $end_date_day = date("d", strtotime("+ 22 days " . $first_monday));

                $is_last_invoice = 0;
                if(($end_date_current_month != $end_date_month) || ($end_date_day > $this->getMonthDates($year, $end_date_month))) 
                    $is_last_invoice = 1; 

                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => $is_last_invoice);
                array_push($arr_invoice, $invoice);

                // third week
                $start_date = date("m月d日", strtotime("+ 14 days "  . $first_monday));
                $end_date = date("m月d日", strtotime("+ 20 days " . $first_monday));
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = date("Y-m-d", strtotime("+ 22 days " . $first_monday));
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                
                // check if last invoice of this month
                if($is_last_invoice == 0){

                    $end_date_current_month = date("m", strtotime("+ 20 days " . $first_monday));
                    $end_date_month = date("m", strtotime("+ 29 days " . $first_monday));
                    $end_date_day = date("d", strtotime("+ 29 days " . $first_monday));
    
                    if(($end_date_current_month != $end_date_month) || ($end_date_day > $this->getMonthDates($year, $end_date_month))) 
                        $is_last_invoice = 1; 
                        
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => $is_last_invoice);
                }
                else 
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);      
                
                array_push($arr_invoice, $invoice);

                // fourth week
                $start_date = date("m月d日", strtotime("+ 21 days "  . $first_monday));
                $end_date = date("m月d日", strtotime("+ 27 days " . $first_monday));
                $period = $year . '年' . $start_date . '～' . $end_date;

                $output_date = date("Y-m-d", strtotime("+ 29 days " . $first_monday));
                $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);

                // check if fifth week
                $end_date_year = intval(date("Y", strtotime("+ 27 days " . $first_monday)));
                $start_date_month = date("m", strtotime("+ 28 days "  . $first_monday));

                if(($end_date_year == $year) && ($start_date_month == $month)) {

                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => ($is_last_invoice == 1) ? 0: 1);
                    array_push($arr_invoice, $invoice);

                    // fifth week
                    $start_date = date("m月d日", strtotime("+ 28 days "  . $first_monday));
                    $end_date = date("m月d日", strtotime("+ 34 days " . $first_monday));
                    $period = $year . '年' . $start_date . '～' . $end_date;

                    $output_date = date("Y-m-d", strtotime("+ 36 days " . $first_monday));
                    $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);
                    array_push($arr_invoice, $invoice);
                }
                else {
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => ($is_last_invoice == 1) ? 0: 1);
                    array_push($arr_invoice, $invoice);
                }

                break;

            case 4:             // 毎日支払い

                $last_invoice = false;
                $first_date = $year . '-' . $month . '-01';
                               
                // Every date
                for($dateIndex=1;$dateIndex<= $current_dates;$dateIndex++){

                    $start_date = $month . '月' . $dateIndex . '日';
                    $end_date = $start_date;
                    $period = $year . '年' . $start_date . '～' . $end_date;

                    $output_date = date('Y-m-d', strtotime('+'. ($dateIndex+2) .' days ' . $first_date));
                    $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);

                    // get date for last invoice 
                    $next_output_date = date('Y-m-d', strtotime('+'. ($dateIndex+3) .' days ' . $first_date));
                    $next_output_date = $this->getNextMonthDate($next_output_date, $pay_cycle->id);
                    $next_output_date = str_replace('年', '-', str_replace('日', '', str_replace('月', '-', $next_output_date)));
                    $next_output_date_month = date('m', strtotime($next_output_date));

                    if(($next_output_date_month != $month) && (!$last_invoice)){
                        $last_invoice = true;
                        $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);    
                    }
                    else    
                        $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);

                    array_push($arr_invoice, $invoice);
                }

                break;
        }

        return $arr_invoice;
    }

    // get month last dates
    public function getMonthDates($year, $month)
    {
        $arr_date_max = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if(($month == 2) && ($year % 4 == 0))
            return 29;

        return $arr_date_max[$month-1];
    }

    public function getNextMonthDate($output_date, $pay_cycle)
    {
        // get year, month
        $output_date = date('Y-m-d', strtotime($output_date));
        $year = substr($output_date, 0,4);
        $month = substr($output_date, 5,2);
        $date = substr($output_date, 8,2);
        if($month >= 12){
            $year++;
            $month = 0;
        }

        // get output date
        if($pay_cycle == 1) {
            $output_date = date('Y-m-d', strtotime($output_date . ' + ' . $this->getMonthDates($year, $month + 1) . 'days'));
        }
        elseif($pay_cycle == 2) {
            if($date == '15')
                $output_date = $year . '-' . intval($month+1) . '-' . $date;
            else
                $output_date = $year . '-' . intval($month+1) . '-' . $this->getMonthDates($year, $month+1);
        }
        elseif($pay_cycle == 3) {

            /*if(intval($date) == 4){

                if($month == 0){
                    $output_date = $year . '-' . intval($month+1) . '-' . $date;
                }
                else {
                    $rest_date = 31 - $this->getMonthDates($year, $month-1);
                    $output_date = $year . '-' . intval($month) . '-' . intval($rest_date+4);
                }
            }
            else {
                $output_date = $year . '-' . intval($month) . '-' . $date;
            }

            $week_day = date('N', strtotime($output_date));
            if($week_day == 4)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 4 day'));
            elseif($week_day == 5)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 3 day'));
            elseif($week_day == 6)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 2 day'));
            elseif($week_day == 7)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 2 day'));
            else
                $output_date = date('Y-m-d', strtotime($output_date . ' + 2 day'));*/

        }
        else {

            /*if($date > $this->getMonthDates($year, intval($month+1))){
                $date -= $this->getMonthDates($year, intval($month+1));
                $output_date = $year . '-' . intval($month+1) . '-' . $date;
            }
            else
                $output_date = $year . '-' . intval($month) . '-' . $date;*/

            $week_day = date('N', strtotime($output_date));
            if($week_day == 6)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 2 day'));
            elseif($week_day == 7)
                $output_date = date('Y-m-d', strtotime($output_date . ' + 1 day'));
        }

        return date('Y年m月d日', strtotime($output_date));

        //return $this->getActiveDate($pay_cycle, $output_date);
    }

    // check if output_date is break
    public function getActiveDate($pay_cycle, $output_date)
    {
        $break_dates = BreakDates::all();
        $active_date = $output_date;
        $bFound = false;

        //while(!$bFound){

            // check week end....
            $week_day = date('N', strtotime($active_date));
            if($week_day == 7){
                $active_date = date('Y-m-d', strtotime($active_date . ' +1 day'));
            }
            else if($week_day == 6){
                $active_date = date('Y-m-d', strtotime($active_date . ' +2 day'));
            }

            // check break dates
            /*$bFound = true;
            foreach($break_dates as $breakDate){

                $str_active_date = date('m-d', strtotime($active_date));
                $str_break_date = date('m-d', strtotime($breakDate->date));
                if($str_break_date == $str_active_date){
                    $bFound  = false;
                    break;
                }
            }

            // +1 day
            if(!$bFound){
                $active_date = date('Y-m-d', strtotime($active_date . ' +1 day'));
            }*/
        //}

        return date('Y年m月d日', strtotime($active_date));
    }


    // -----------------------------------------------------------------------------------------------------------------
    // make invoices automatically
    // -----------------------------------------------------------------------------------------------------------------

    public function autoInvoices()
    {
        set_time_limit(10000);

		$time1 = time();

        $today = Setting::getToday();
        $today_date_obj = new DateTime($today);
        $auto_invoice_date = date('Y-m-d', strtotime($today));

        $userlist = User::all()->sortByDesc('created_at');
        foreach($userlist as $user){

            // get invoice dates
            $arr_invoice = $this->getTodayInvoices($auto_invoice_date, $user); 
            foreach($arr_invoice as $invoice)
                $this->createInvoice($invoice, $user);
        }

        // print time
        echo 'Completed!' . '<br>' . 'Times: ';
		echo time()-$time1 . 's'; 
    }

    // --------------------------------------------------------------------------------------------------------------
    // get Invoices for today
    // --------------------------------------------------------------------------------------------------------------

    public function getTodayInvoices($invoice_date, $user)
    {
        // pay_cycle
        if($user->type == '1'){
            $pay_cycle = PayCycle::findById(1);
        }
        else {
            $shop = Shop::getShopInfoByName($user->name);
            $pay_cycle = PayCycle::findById($shop->s_paycycle_id);
        }

        // year, month, dates
        $year = intval(substr($invoice_date, 0, 4));
        $month = intval(substr($invoice_date, 5, 2));
        $dates = intval(substr($invoice_date, 8, 2));

        $current_year = $year;
        $current_month = $month;
        //$current_dates = $this->getMonthDates($year, $month);   // 30 or 31

        // invoice
        $arr_invoice = array();
        switch($pay_cycle->id){
            case 1:             // 月1支払い

                if($dates == '01') {

                    $month--;
                    if($month == 0){
                        $month = 12;
                        $year--;
                    }

                    $current_dates = $this->getMonthDates($year, $month);

                    $start_date = $month . '月1日';
                    $end_date = $month . '月' . $current_dates . '日';
                    $period = $year . '年' . $start_date . '～' . $end_date;                    

                    $output_date = $year . '-' . $month . '-' . $current_dates;
                    $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
    
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);
                    array_push($arr_invoice, $invoice);
                }

                break;

            case 2:             // 月2支払い

                if($dates == 16) {

                    // 同月16日
                    $start_date = $month . '月1日';
                    $end_date = $month . '月15日';
                    $period = $year . '年' . $start_date . '～' . $end_date;
    
                    $output_date = $current_year . '-' . $current_month . '-15';
                    $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);
                    array_push($arr_invoice, $invoice);
                }                
                elseif($dates == '01') {

                    // 翌月1日
                    $month--;
                    if($month == 0){
                        $month = 12;
                        $year--;
                    }

                    $current_dates = $this->getMonthDates($year, $month);

                    $start_date = $month . '月16日';
                    $end_date = $month . '月' . $current_dates . '日';
                    $period = $year . '年' . $start_date . '～' . $end_date;
    
                    $output_date = $year . '-' . $month . '-' . $current_dates;
                    $output_date = $this->getNextMonthDate($output_date, $pay_cycle->id);
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);
                    array_push($arr_invoice, $invoice);
                }

                break;

            case 3:             // 週１支払い

                // 毎週 月曜日
                $date_val = date('w', strtotime($invoice_date));
                if($date_val == 1) {
                    
                    $last_monday = date("Y-m-d", strtotime("last week monday", strtotime($invoice_date)));
                    if($last_monday != $invoice_date)
                        $is_last_invoice = 0;
                    else
                        $is_last_invoice = 1;

                    $start_date = date("m月d日", strtotime("-7 days" . $invoice_date));
                    $end_date = date("m月d日", strtotime("-1 day" . $invoice_date));
                    $period = $year . '年' . $start_date . '～' . $end_date;
                    $output_date = date("Y-m-d", strtotime("+ 1 day " . $invoice_date));
                    $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => $is_last_invoice);
                    array_push($arr_invoice, $invoice);
                }

                break;

            case 4:             // 毎日支払い

                $date_val = date('w', strtotime($invoice_date));
                if($date_val < 5) {
                    if($date_val == 0) {

                        // 日翌日
                        $start_date = date('m月d日', strtotime('- 3 days '. $invoice_date));
                        $end_date = date('m月d日', strtotime('- 1 day '. $invoice_date));
                        $period = $year . '年' . $start_date . '～' . $end_date;
                        $output_date = date('Y-m-d', strtotime('+ 1 day ' . $invoice_date));

                        $start_date_month = date('m', strtotime('- 3 days '. $invoice_date));
                        if($start_date_month == $month) {

                            $current_dates = $this->getMonthDates($year, $month);
                            if($current_dates == $dates)
                                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1); 
                            else
                                $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0); 
                        }
                        else
                            $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);

                    }
                    else {

                        // 月、火、水、木翌日
                        $start_date = $end_date = date('m月d日', strtotime('- 1 day ' . $invoice_date));
                        $period = $year . '年' . $start_date . '～' . $end_date;
                        $output_date = date('Y-m-d', strtotime('+ 1 day ' . $invoice_date));

                        $current_dates = $this->getMonthDates($year, $month);
                        if($current_dates == $dates)
                            $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 1);
                        else
                            $invoice = array('year' => $year, 'start_date' => $start_date, 'end_date' => $end_date, 'period' => $period, 'output_date' => $output_date, 'month_fee' => 0);
                    }
    
                    array_push($arr_invoice, $invoice);
                }

                break;
        }

        return $arr_invoice;
    }

    // --------------------------------------------------------------------------------------------------------------
    // create invoice
    // --------------------------------------------------------------------------------------------------------------
    
    public function createInvoice($invoice, $user)
    {
        // start, end date
        $year = $invoice['year'];
        $start = $invoice['start_date'];
        $end = $invoice['end_date'];
        $start_date = $year . '-' . str_replace('日', '', str_replace('月', '-', $start));
        $end_date = $year . '-' . str_replace('日', '', str_replace('月', '-', $end));
        
        // check if there is no transaction.
        $data['transaction_count'] = Transaction::getCountByUser($start_date, $end_date, $user);
        if($data['transaction_count'] == 0) return;
        
        // pay_cycle
        if($user->type == '1'){
            $pay_cycle = PayCycle::findById(1);
            $merchant =  Merchant::getUserInfoByName($user->name);
            $merchant_name = $merchant->u_name;
            $merchant_id = $merchant->name;
            $shop_name = '';
            $shop_id = '';
        }
        else {
            $shop = Shop::getShopInfoByName($user->name);
            $pay_cycle = PayCycle::findById($shop->s_paycycle_id);
            $merchant =  Merchant::getUserInfoByName($shop->member_id);
            $merchant_name = $merchant->u_name;
            $merchant_id = $merchant->name;
            $shop_name = $shop->s_name;
            $shop_id = $shop->name;
        }

        $data['merchant_id'] = $merchant_id;
        $data['shop_id'] = $shop_id;
        $data['shop_name'] = $shop_name;
        $data['merchant_name'] = $merchant_name;
        $data['merchant_username'] = $merchant_name;
        $data['pay_cycle'] = $pay_cycle->id;

        $Invoiced = Invoice::checkInvoice($data, $start_date, $end_date);
        if($Invoiced) return;

        // get latest invoice
        $output_date = $invoice['output_date'];
        $last_invoice = Invoice::getLastInvoice($data);
        $pay_cycle_id = $pay_cycle->id;

        // get information for count, amount
        $data = Transaction::getDataByUser($start_date, $end_date, $user, $data);

        $visa_count = Transaction::getAllCount($start_date, $end_date, $user, '', 1);
        $master_count = Transaction::getAllCount($start_date, $end_date, $user, '', 2);
        $jcb_count = Transaction::getAllCount($start_date, $end_date, $user, '', 3);
        $amex_count = Transaction::getAllCount($start_date, $end_date, $user, '', 4);
        
        // sms transaction count by card id
        $visa_sms_count = Transaction::getSMSCountByCard($user, 1);
        $master_sms_count = Transaction::getSMSCountByCard($user, 2);
        $jcb_sms_count = Transaction::getSMSCountByCard($user, 3);
        $amex_sms_count = Transaction::getSMSCountByCard($user, 4);

        // card fee
        $visa_fee = ($user->type == '1') ? $merchant->u_visa_fee: $shop->sm_visa_fee;
        $master_fee = ($user->type == '1') ? $merchant->u_master_fee: $shop->sm_master_fee;
        $jcb_fee = ($user->type == '1') ? $merchant->u_jcb_fee: $shop->sm_jcb_fee;
        $amex_fee = ($user->type == '1') ? $merchant->u_amex_fee: $shop->sm_amex_fee;

        $data['visa_fee'] = ($user->type == '1') ? $merchant->u_visa_fee_low: $shop->s_visa_fee;
        $data['master_fee'] = ($user->type == '1') ? $merchant->u_master_fee_low: $shop->s_master_fee;
        $data['jcb_fee'] = ($user->type == '1') ? $merchant->u_jcb_fee_low: $shop->s_jcb_fee;
        $data['amex_fee'] = ($user->type == '1') ? $merchant->u_amex_fee_low: $shop->s_amex_fee;
        
        //  RR payment period
        $total = ceil($data['v_amount']);
        $total += ceil($data['m_amount']);
        $total += ceil($data['j_amount']);
        $total += ceil($data['a_amount']);
        $rr_payment_amount = ceil($total * 0.05);
        $rr_invoice_amount = Transaction::getRRAmount($output_date, $user);
        
        // cancel fee
        if($user->type == '2'){
            $cancel_fee = $shop->s_cancel_fee;
            $enter_fee = $shop->s_enter_fee;
        }
        else {
            $cancel_fee = 300;
            $enter_fee = 500;
        }

        // monthly fee
        $month_fee = 0;
        if($invoice['month_fee'] == 1){
            $month_fee = $this->getMonthFee($pay_cycle->id, $total, $year, $end);
        }           

        // order date
        //$order_date = $this->getOrderDate($start_date, $pay_cycle->id);
        //$order_date = str_replace('年', '-', str_replace('日', '', str_replace('月', '-', $order_date)));
        
        $a = ceil($data['v_amount']) + ceil($data['m_amount']) + ceil($data['j_amount']) + ceil($data['a_amount']);
        $cc_total = $data['v_cc_count'] + $data['m_cc_count'] + $data['j_cc_count'] + $data['a_cc_count'];
        $b = ceil($data['v_cc_amount']) + ceil($data['m_cc_amount']) + ceil($data['j_cc_amount']) + ceil($data['a_cc_amount']);
        $cb_count = $data['v_cb_count'] + $data['m_cb_count'] + $data['j_cb_count'] + $data['a_cb_count'];
        $c = ceil($data['v_cb_amount']) + ceil($data['m_cb_amount']) + ceil($data['j_cb_amount']) + ceil($data['a_cb_amount']);
        $d = $month_fee;
        $e = ceil(($data['visa_fee'] * $data['v_amount'] + $data['master_fee'] * $data['m_amount'] + $data['jcb_fee'] * $data['j_amount'] + $data['amex_fee'] * $data['a_amount'])/100);
        $f = ($visa_count + $master_count + $jcb_count + $amex_count) * 50;
        $g = ($visa_sms_count + $master_sms_count + $jcb_sms_count + $amex_sms_count) * 20;
        $h = $cc_total * $cancel_fee;
        $i = $c;
        $j = ceil(($d + $e + $f + $g + $h + $i) / 10);
        $k = $enter_fee;
        $l = 0;
        if($last_invoice != null){
            if(($last_invoice->pay_amount < 3000) && !$Invoiced) {
                $l = $last_invoice->pay_amount;
            }

            $data['added'] = 1;
            $data['carry_date'] = $last_invoice->invoice_date;
        }
        else {
            $data['carry_date'] = date('Y-m-d');
            $data['added'] = 0;
        }

        $m = $n = 0;
        if($pay_cycle_id > 2){
            $m = $rr_payment_amount;
            $n = $rr_invoice_amount;
        }

        $sum = ceil($a+$l+$n-($b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$m));
        if($sum + $k < 3000){
            $sum += $k;
            $k = 0;
        }

        // added
        $data['pay_cycle'] = $pay_cycle_id;
        $data['payment_start'] = date('Y-m-d', strtotime($start_date));
        $data['payment_end'] =  date('Y-m-d', strtotime($end_date));
        $data['pay_amount'] = $sum;
        //$data['invoice_date'] = $order_date;
        $data['output_date'] = str_replace('年', '-' , str_replace('日', '', str_replace('月', '-', $output_date)));
        $data['invoice_date'] = date('Y-m-d', strtotime('+ 1 day ' . $end_date));

        $data['month_fee'] = $month_fee;
        $data['payment_fee'] = $e;
        $data['tf_fee'] = $f;
        $data['sms_fee'] = $g;
        $data['cc_fee'] = $h;
        $data['cb_fee'] = $i;
        $data['enter_fee'] = $k;

        $data['transaction_amount'] = ceil($a);
        $data['cc_count'] = $cc_total;
        $data['cc_amount'] = ceil($b);
        $data['cb_count'] = $cb_count;
        $data['cb_amount'] = ceil($c);

        $data['carry_amount'] = 0;
        if($last_invoice != null){
            if(($last_invoice->pay_amount < 3000) && !$Invoiced) {
                $data['carry_amount'] = $last_invoice->pay_amount;
            }

            $data['carry_date'] = $last_invoice->invoice_date;
        }
        else {
            $data['carry_date'] = date('Y-m-d');
        }

        $data['rr_amount'] = $m;
        $data['rr_pay'] = $n;

        $data['v_fee'] = ceil($data['visa_fee'] * $data['v_amount']/100);
        $data['v_tf_fee'] = $visa_count * 50;
        $data['v_sms_fee'] = $visa_sms_count * 20;
        $data['v_cc_fee'] = ceil($data['v_cc_count'] * $cancel_fee);
        $data['v_cb_fee'] = ceil($data['v_cb_amount']);
        $data['v_tax'] = ceil(($data['visa_fee'] * $data['v_amount']/100 + $visa_count * 50 + $visa_sms_count * 2 + $data['v_cc_count'] * $cancel_fee + $data['v_cb_amount']) * 0.1);

        $data['m_fee'] = ceil($data['master_fee'] * $data['m_amount']/100);
        $data['m_tf_fee'] = $master_count * 50;
        $data['m_sms_fee'] = $master_sms_count * 20;
        $data['m_cc_fee'] = ceil($data['m_cc_count'] * $cancel_fee);
        $data['m_cb_fee'] = ceil($data['m_cb_amount']);
        $data['m_tax'] = ceil(($data['master_fee'] * $data['m_amount']/100 + $master_count * 50 + $master_sms_count * 2 + $data['m_cc_count'] * $cancel_fee + $data['m_cb_amount']) * 0.1);

        $data['j_fee'] = ceil($data['jcb_fee'] * $data['j_amount']/100);
        $data['j_tf_fee'] =  $jcb_count * 50;
        $data['j_sms_fee'] = $jcb_sms_count * 20;
        $data['j_cc_fee'] = ceil($data['j_cc_count'] * $cancel_fee);
        $data['j_cb_fee'] = ceil($data['j_cb_amount']);
        $data['j_tax'] = ceil(($data['jcb_fee'] * $data['j_amount']/100 + $jcb_count * 50 + $jcb_sms_count * 2 + $data['j_cc_count'] * $cancel_fee + $data['j_cb_amount']) * 0.1);

        $data['a_fee'] = ceil($data['amex_fee'] * $data['a_amount']/100);
        $data['a_tf_fee'] =  $amex_count * 50;
        $data['a_sms_fee'] = $amex_sms_count * 20;
        $data['a_cc_fee'] = ceil($data['a_cc_count'] * $cancel_fee);
        $data['a_cb_fee'] = ceil($data['a_cb_amount']);
        $data['a_tax'] = ceil(($data['amex_fee'] * $data['a_amount']/100 + $amex_count * 50 + $amex_sms_count * 2 + $data['a_cc_count'] * $cancel_fee + $data['a_cb_amount']) * 0.1);

        $data['tax'] = ceil($j);

        // invoice
        $invoice = new Invoice();
        $invoice->fill($data);
        $invoice->save();
    }
}