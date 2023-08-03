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
use App\Models\Setting;
use App\Models\User;
use App\Models\Mailer;

class HomeController extends CustomerController
{
    protected $platform = 'customer';

    public function index()
    {
        Session::put('menu', 'home');
        Setting::setDates('', '');

        // check if status of shop is available.
        $this->view_datas['invoice_url'] = url('invoice') . '/' . str_replace('/', '', Auth::user()->remember_token);
        $this->view_datas['user'] = User::getDetail(Auth::user()->id);
        return view("{$this->platform}.home.index",  ['datas' => $this->view_datas]);
    }

    public function mail(Request $request)
    {
        $params = $request->all();

        $from = '';
        if(isset($params['from']))
            $from = $params['from'];

        Mailer::sendEmail($params['to'], $params['message'], $params['subject'], $from);
    }

    public function email(Request $request)
    {
        Mailer::sendConfirm();
    }
}