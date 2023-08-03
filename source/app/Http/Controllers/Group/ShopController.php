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
use Symfony\Component\HttpFoundation\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Validator;
use Session;
use App;
use DateTime;
use DateTimeZone;

use App\Models\User;
use App\Models\Shop;
use App\Models\Group;
use App\Models\Transaction;

class ShopController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'shop';
        $this->menu = 'shop';
        parent::__construct();
    }

    public function index()
    {
        // check if pagination with search
        $params = array();
        $path_full = parse_url(url()->full());
        if(isset($path_full['query']))
            parse_str($path_full['query'], $params);
        
        if(sizeof($params) > 1) {

            // get transaction list
            $this->view_datas['year'] = $params['year'];
            $this->view_datas['month'] = $params['month'];
            $this->view_datas['pagelen'] = $params['pagelen'];
        }
        else {

             // get transaction list
            $this->view_datas['year'] = date('Y');
            $this->view_datas['month'] = date('m');
            $this->view_datas['pagelen'] = 50;
        }
        
        $list = Group::getShopSummary($this->view_datas, Auth::guard('group')->user());
        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['pagelen'], null, array('path' => url('/group/shop/')));
        
        return parent::index();
    }

    // pagination
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();
        $list = Group::getShopSummary($params, Auth::guard('group')->user());
        $params['list'] = $this->paginate($list, $params['pagelen'], null, array('path' => url('/group/shop')));

        $this->view_datas = $params;
        return parent::index();
    }

    // switch to shop login
    public function postSwitch(Request $request)
    {
        // logout
        Auth::guard('group')->logout();

        // client login
        $params = $request->all();
        $user = User::getUserByName($params['name']);
        
        Auth::guard('merchant')->attempt(['name' => $user->name, 'password' => $user->password1]);

        Session::put('user_role', 'merchant');
        Session::save();
        return redirect('merchant/dashboard');
    }

    // switch to shop invoice
    public function postShowInvoice(Request $request)
    {
        // logout
        Auth::guard('group')->logout();

        // client login
        $params = $request->all();
        $user = User::getUserByName($params['shop_name']);
        Auth::guard('web')->attempt(['name' => $user->name, 'password' => $user->password1]);

        // save session
        Session::put('user_role', 'web');
        Session::save();

        // show invoice
        $invoice_url = url('invoice') . '/' . str_replace('/', '', $user->remember_token);
        //die(json_encode(['url' => $invoice_url]));
        return redirect($invoice_url);
    }
}