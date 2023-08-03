<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/20/2018
 * Time: 11:48 AM
 */

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Group\CustomerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Validator;
use Session;
use App;

use App\Models\Group;
use App\Models\Shop;
use App\Models\Merchant;


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
        if(!$this->checkStatus()) {
            Auth::guard('group')->logout();
            return redirect('/group');
        }

        return parent::index();
    }

    public function checkStatus()
    {
        $user = Auth::guard('group')->user();
        if($user->type == 1) {
            $merchant = Merchant::getUserByName($user->name);
            return ($merchant->u_status == '契約中');
        }
        else if($user->type == 2) {
            $shop = Shop::getShopByName($user->name);
            return ($shop->s_status == '契約中');
        }
        else {
            $group = Group::getGroupByName($user->name);
            return ($group->g_status == '契約中');
        }

        return false;
    }
}