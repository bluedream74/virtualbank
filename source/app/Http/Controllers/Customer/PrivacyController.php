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
use Validator;
use Session;
use App;
use App\Models\Setting;

class PrivacyController extends CustomerController
{
    protected $platform = 'customer';

    public function index()
    {
        Session::put('menu', 'home');
        return view("{$this->platform}.privacy.index",  ['datas' => $this->view_datas]);
    }
}