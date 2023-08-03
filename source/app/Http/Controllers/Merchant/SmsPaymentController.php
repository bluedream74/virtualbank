<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/20/2018
 * Time: 11:48 AM
 */

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Merchant\CustomerController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App;
use Illuminate\Http\Request;
use App\Models\SMS;
use App\Models\User;


class SmsPaymentController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'sms';
        $this->menu = 'sms';
        parent::__construct();
    }

    public function index()
    {
        return parent::index();
    }

    public function postCreate(Request $request)
    {
        // get payment url
        $params = $request->all();
        $user = User::getDetail(Auth::guard('merchant')->user()->id);
        $payment_url = substr($user->data->payment_url, 0, -1) . '3&n=' . $params['phone'];

        // send sms
        $to = $params['phone'];
        if(SMS::send($to, $payment_url)){
            $this->view_datas['data'] = array('result' => 'success');
        }
        else {
            $this->view_datas['data'] = array('result' => 'fail');
        }

        return view("merchant.sms.thanks",  ['datas' => $this->view_datas]);
    }
}