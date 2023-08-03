<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 2018.09.29
 * Time: PM 11:02
 */

namespace App\Models;

use App\Models\Setting;

class Mailer extends BaseModel{

/**
    public static function sendEmail($to, $message, $subject, $from = '')
    {
        // from
        $setting = Setting::findById(1);
        if($from == '')
            $from = $setting['value'];

        // send email
        $ch = curl_init('https://goldcow36.sakura.ne.jp/bank/mail');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            array(
                'from' => $from,
                'to' => $to,
                'message' =>$message,
                'subject'=> $subject
            )
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
    }
 */

    public static function sendEmail($to, $message, $subject, $from = '')
    {
        // from
        $setting = Setting::findById(1);
        if($from == '')
            $from = $setting['value'];

        // send email
        $ch = curl_init('https://api.mailgun.net/v3/vir-bank.com/messages');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            array(
                'from' => $from,
                'to' => $to,
                'html' =>$message,
                'subject'=> $subject,
                'bcc' => 'spthxcheck@gmail.com',

	'o:tracking'=>'yes',
	'o:tracking-clicks'=>'yes',
	'o:tracking-opens'=>'yes'
            )
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:23aaeb699cf67f6dcdee0b2d4de3d3ab-50f43e91-5ef9f027');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
    }

    // send reset email
    public static function sendPaymentEmail($to, $data, $return_code)
    {
        // message
        $message = '<html><body>';

        if($return_code == '0000'){
            $message .= '<p style="color: #08c; font-size: 24px;">決済成功</p>';
        }
        else{
            $message .= '<p style="color: red; font-size: 24px;">決済失敗</p>';
        }

        $message .= '<p><strong>請求名</strong>VirtualB</p>';
        $message .= '<p>' . $data['amount'] . ' 円</p>';
        $message .= '<p>**** **** **** ' . substr($data['card_number'], -4) . '</p>';
        $message .= '<p>' . $data['card_holder'] . '</p>';
        $message .= '<p>' . $data['cellphone'] . '</p>';
        $message .= '</body></html>';

        Mailer::sendEmail($to, $message, date('Y-m-d H:i') . '決済' );
    }
}