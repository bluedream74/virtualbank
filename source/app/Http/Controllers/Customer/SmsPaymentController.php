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
use Symfony\Component\HttpFoundation\Request;
use Validator;
use Session;
use App;
use App\Models\SMS;
use App\Models\User;

class SmsPaymentController extends CustomerController
{
    protected $platform = 'customer';

    public function index()
    {
        Session::put('menu', 'home');
        return view("{$this->platform}.sms.index",  ['datas' => $this->view_datas]);
    }

    public function postCreate(Request $request)
    {
        // get payment url
        $params = $request->all();
        $user = User::getDetail(Auth::user()->id);
        $payment_url = substr($user->data->payment_url, 0, -1) . '3&n=' . $params['phone'];

        // send sms
        $to = $params['phone'];
        if(SMS::send($to, $payment_url)){
            $this->view_datas['data'] = array('result' => 'success');
        }
        else {
            $this->view_datas['data'] = array('result' => 'fail');
        }

        return view("{$this->platform}.sms.thanks",  ['datas' => $this->view_datas]);
    }
}