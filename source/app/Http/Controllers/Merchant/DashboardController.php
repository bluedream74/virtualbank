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

class DashboardController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'dashboard';
        $this->menu = 'dashboard';
        parent::__construct();
    }

    public function index()
    {
        $user = User::getDetail(Auth::guard('merchant')->user()->id);
        $user_status = User::getUserStatus(Auth::guard('merchant')->user()->name);

        Session::put('payment_url', $user->data->payment_url );
        Session::save();

        return parent::index();
    }
}