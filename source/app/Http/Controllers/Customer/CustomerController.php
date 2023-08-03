<?php
/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/23/2018
 * Time: 1:01 PM
 */

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Session;
use App;

class CustomerController extends Controller
{
    protected $view_datas;
    public function __construct(){
        set_time_limit(10000);
    }
}