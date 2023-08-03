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
use Illuminate\Support\Facades\Request;
use Validator;
use Session;
use App;
use App\Models\User;

class QRPaymentController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'qr';
        $this->menu = 'qr';
        parent::__construct();
    }

    public function index()
    {
        $user = User::getDetail(Auth::guard('merchant')->user()->id);
        $this->view_datas['payment_url'] = substr($user->data->payment_url,0,-1) . 2;
        return parent::index();
    }

    public function showEdit(Request $request)
    {
        $user = User::getDetail(Auth::guard('merchant')->user()->id);
        $this->view_datas['payment_url'] = substr($user->data->payment_url,0,-1) . 2;
        return view("merchant.{$this->platform}.edit", ['datas'=>$this->view_datas]);
    }
}