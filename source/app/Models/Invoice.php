<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;

class Invoice extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'invoice';
    public $primaryKey = 'id';
    protected $fillable = ['merchant_username', 'merchant_id','merchant_name','shop_id','shop_name','pay_cycle','payment_start','payment_end','pay_amount','invoice_date','output_date','month_fee','payment_fee','tf_fee','sms_fee','cc_fee','cb_fee','enter_fee','transaction_count','transaction_amount','cc_count','cc_amount','cb_count','cb_amount','carry_amount','carry_date','rr_amount','rr_pay','v_count','v_amount','v_cc_count','v_cc_amount','v_cb_count','v_cb_amount','m_count','m_amount','m_cc_count','m_cc_amount','m_cb_count','m_cb_amount','j_count','j_amount','j_cc_count','j_cc_amount','j_cb_count','j_cb_amount','a_count','a_amount','a_cc_count','a_cc_amount','a_cb_count','a_cb_amount','v_fee','v_tf_fee','v_sms_fee','v_cc_fee','v_cb_fee','v_tax','m_fee','m_tf_fee','m_sms_fee','m_cc_fee','m_cb_fee','m_tax','j_fee','j_tf_fee','j_sms_fee','j_cc_fee','j_cb_fee','j_tax','a_fee','a_tf_fee','a_sms_fee','a_cc_fee','a_cb_fee','a_tax', 'tax', 'visa_fee', 'jcb_fee', 'master_fee', 'amex_fee', 'added'];

    public static function getAll($data = null)
    {
        // search
        if($data) {
            
            $arr_where = array();

            // 決済期間
            $start_date = '1900-01-01';
            $end_date = '9999-01-01';
            if(isset($data['start_date']) && ($data['start_date'] != ''))
                $start_date = $data['start_date'];
            if(isset($data['end_date']) && ($data['end_date'] != ''))
                $end_date = $data['end_date'];
            
            $start_date .= ' 00:00';
            $end_date .= ' 23:59';
        
            // ご入金予定日   
            $start_output_date = '1900-01-01';
            $end_output_date = '9999-01-01';
            if(isset($data['start_output']) && ($data['start_output'] != ''))
                $start_output_date = $data['start_output'];   
            if(isset($data['end_output'])  && ($data['end_output'] != ''))
                $end_output_date = $data['end_output'];
    
            $start_output_date .= ' 00:00';
            $end_output_date .= ' 23:59';
        
            // 発行日
            $start_invoice = '1900-01-01';
            $end_invoice = '9999-01-01';
            if(isset($data['start_invoice']) && ($data['start_invoice'] != ''))
                $start_invoice = $data['start_invoice'];
            if(isset($data['end_invoice']) && ($data['end_invoice'] != ''))
                $end_invoice = $data['end_invoice'];

            $start_invoice .= ' 00:00';
            $end_invoice .= ' 23:59';

            // 決済金額
            $amount_min = -99999999999999999999999999999999999;
            $amount_max = 999999999999999999999999999999999999;
            if(isset($data['amount_min']) && ($data['amount_min'] != ''))
                $amount_min = $data['amount_min'];
            if(isset($data['amount_max']) && ($data['amount_max'] != ''))
                $amount_max = $data['amount_max'];

            // 精算ID
            if(isset($data['invoice_id']) && ($data['invoice_id'] != '')){
                array_push($arr_where, ['invoice.id', $data['invoice_id']]);
            }            

            // 加盟店ID
            if(isset($data['merchant_id']) && ($data['merchant_id'] != '')) {
                array_push($arr_where, ['invoice.merchant_id', $data['merchant_id']]);
            }

            // 店舗ID
            if(isset($data['shop_id']) && ($data['shop_id'] != '')) {
                array_push($arr_where, ['invoice.shop_id', $data['shop_id']]);
            }

            // 店舗名
            if(isset($data['shop_name']) && ($data['shop_name'] != '')) {
                array_push($arr_where, ['invoice.shop_name', $data['shop_name']]);
            }
            
            // 支払いサイクル
            if(isset($data['pay_cycle']) && ($data['pay_cycle'] != '')) {
                array_push($arr_where, ['invoice.pay_cycle', $data['pay_cycle']]);
            }

            // where
            array_push($arr_where, ['invoice.payment_start', '>=', $start_date]);
            array_push($arr_where, ['invoice.payment_end', '>=', $start_date]);
            array_push($arr_where, ['invoice.payment_start', '<=', $end_date]);
            array_push($arr_where, ['invoice.payment_end', '<=', $end_date]);
            array_push($arr_where, ['invoice.output_date', '>=', $start_output_date]);
            array_push($arr_where, ['invoice.output_date', '<=', $end_output_date]);
            array_push($arr_where, ['invoice.invoice_date', '>=', $start_invoice]);
            array_push($arr_where, ['invoice.invoice_date', '<=', $end_invoice]);
            array_push($arr_where, ['invoice.pay_amount', '>=', $amount_min]);
            array_push($arr_where, ['invoice.pay_amount', '<=', $amount_max]);

            return self::select('invoice.*', 'paycycle_type.name as pay_cycle_name')
                ->join('paycycle_type', 'invoice.pay_cycle', '=', 'paycycle_type.id')
                ->where($arr_where)
                ->orderBy('invoice.created_at', 'DESC')
                ->get();
        }
        
        // default
        return self::select('invoice.*', 'paycycle_type.name as pay_cycle_name')
                ->join('paycycle_type', 'invoice.pay_cycle', '=', 'paycycle_type.id')
                ->orderBy('invoice.created_at', 'DESC')
                ->get();
    }

    public static function getDetail($id)
    {
        $invoice = self::findById($id);

        $pay_cycle = PayCycle::findById($invoice->pay_cycle);
        $invoice->pay_cycle_name = $pay_cycle->name;
        return $invoice;
    }

    public static function checkInvoice($data, $start_date, $end_date)
    {
        $invoice = self::where('merchant_id', $data['merchant_id'])
                    ->where('shop_id', $data['shop_id'])
                    ->where('shop_name', $data['shop_name'])
                    ->where('pay_cycle', $data['pay_cycle'])
                    ->where('payment_start', $start_date)
                    ->where('payment_end', $end_date)
                    ->first();

        if($invoice)
            return $invoice->id;
        return 0;
    }

    // get latest invoice for current shop or, merchant
    public static function getLastInvoice($data)
    {
        return self::where('merchant_id', '=', $data['merchant_id'])
            ->where('shop_id', '=', $data['shop_id'])
            ->where('shop_name', '=', $data['shop_name'])
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    // invoices with merchant id, and output_date
    public static function getAllByMerchant($merchant_id, $output_date)
    {
        if($output_date == '')
            $output_date = date('Y-m-d');
        else
            $output_date = date('Y-m-d', strtotime($output_date));

        return self::where('merchant_id', '=', $merchant_id)->where('output_date', '=' , $output_date)->get();
    }
}
