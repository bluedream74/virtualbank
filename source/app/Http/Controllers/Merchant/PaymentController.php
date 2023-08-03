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
use App\Models\User;

class PaymentController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'payment';
        $this->menu = 'payment';
        parent::__construct();
    }

    public function index()
    {
        $user = User::getDetail(Auth::guard('merchant')->user()->id);
        $this->view_datas['payment_url'] = $user->data->payment_url;
        return parent::index();
    }
}