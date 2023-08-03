<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 2018.09.29
 * Time: PM 11:02
 */

namespace App\Models;

//require_once __DIR__.'/Twilio/autoload.php';
//use Twilio\Rest\Client;

class SMS extends BaseModel{

    public static function send($to, $message)
    {
        $url = 'https://qpd-api.aossms.com/p5/api/mt.json';
        /*$data = array(
          'token' => '9ecc18f726faf7c0cd865c0f59a01ecc'        //トークンを設定
        , 'clientId' => '1139'                                     //クライアント IDを設定
        , 'smsCode' => '82981'                                     // SMSコードを設定
        , 'message' => $message                                     //送信したいメッセージを設定
        , 'phoneNumber' => $to                                     //送信したい宛先電話番号を設定 $to
        );*/

        $data = array(
            'token' => '29b7e46fe7de157d37328ceb546f6d6f'        //トークンを設定
        , 'clientId' => '7107'                                     //クライアント IDを設定
        , 'smsCode' => '87933'                                     // SMSコードを設定
        , 'message' => $message                                     //送信したいメッセージを設定
        , 'phoneNumber' => $to                                     //送信したい宛先電話番号を設定 $to
        );

        $content = http_build_query($data); // URLエンコードされたクエリ文字列を生成
        $header = array( //リクエストヘッダを設定
            "Content-Type: application/x-www-form-urlencoded"
        , "Content-Length: ".strlen($content)
        );

        $options = array( // HTTPコンテキストオプションを設定
            "http" => array(
                'method' => 'POST'
            , 'header' => implode("\r\n", $header)
            , 'content' => $content
            )
        );

        $contents = file_get_contents($url, false, stream_context_create($options)); //SMS送信をリクエスト
        $res = json_decode($contents);
        if($res->responseCode == 0)
            return true;

        return false;
    }

    public static function sendPayment($to, $amount)
    {
        $today = date("Y-m-d H:i");

        $str_msg = '決済成功案内' . '\n';
        $str_msg .= $today . '\n';
        $str_msg .= $amount . ' 円';
        $str_msg .= '請求名: VirtualBankバーチャルバンク';

        self::send($to, $str_msg);
    }

    // send message via Twillio
    public static function sendTwillio($to, $message)
    {
        /*$sid = 'AC546c1622a87fca0b630c177d1c94a3fb';
        $token = '3f0b40de241fec270e304cdbe963340a';
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!      sample: +447533328239
        $message = $client->messages->create('+815058653103',   // $to
            [
                'from' => '+12024103364',
                "body" => $message
            ]
        );

        if(($message->status == 'sent') || ($message->status == 'queued'))
            return true;
        return false;*/
        return true;
    }

}