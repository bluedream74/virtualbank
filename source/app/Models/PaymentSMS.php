<?php

namespace App\Models;

class PaymentSMS extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'payment_sms';
    public $primaryKey = 'id';

    public static function addPaymentSms($data)
    {
        $sms = new PaymentSMS();
        $sms->type = $data['type'];
        $sms->name = $data['name'];
        $sms->m_name = $data['m_name'];
        $sms->payment_method_id = $data['payment_method_id'];
        $sms->payment_token = $data['payment_token'];
        $sms->supplier = $data['supplier'];
        $sms->amount = $data['amount'];
        $sms->card_number = str_replace(' ', '', $data['card_number']);
        $sms->cardtype_id = $data['cardtype_id'];
        $sms->cardtype_name = $data['cardtype_name'];
        $sms->card_exp_month = $data['card_exp_month'];
        $sms->card_exp_year = $data['card_exp_year'];
        $sms->card_holdername = $data['card_holdername'];
        $sms->card_cvv = $data['card_cvv'];
        $sms->phone = $data['phone'];
        $sms->save();
        return $sms;
    }

    public static function getByTimeStamp($id, $timestamp)
    {
        $paymentSms = self::findById($id); 
        if(strtotime($paymentSms->created_at) == $timestamp)
            return $paymentSms;            
        return null;
    }
}
