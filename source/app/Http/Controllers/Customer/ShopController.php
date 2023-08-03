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

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Setting;
use App\Models\Group;
use App\Models\User;

class ShopController extends CustomerController
{
    protected $platform = 'customer';

    public function index()
    {
        Session::put('menu', 'home');

        if(Auth::user()->type != 3) {
            return redirect('/');
        }

        // search filter
        $this->view_datas['page_len'] = Setting::getPageLen();
        $this->view_datas['year'] = date('Y');
        $this->view_datas['month'] = date('m');

        if(session('year')){
            $this->view_datas['year'] = session('year');
            $this->view_datas['month'] = session('month');
        }
        else {

            $path_full = parse_url(url()->full());
            if(isset($path_full['query'])) {
                parse_str($path_full['query'], $params);
                if(sizeof($params) > 1) {
                    $this->view_datas['year'] = $params['year'];
                    $this->view_datas['month'] = $params['month'];
                }
            }
        }

        // check if status of shop is available.
        $list = Group::getShopSummary($this->view_datas, Auth::user());
        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['page_len'], null, array('path' => url('/shop')));
        return view("{$this->platform}.shop.index",  ['datas' => $this->view_datas]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function postPageLen(Request $request)
    {
        $params = $request->all();
        Setting::setPageLen($params['page_len']);

        return redirect('/shop')->with(['year' => $params['year1'], 'month' => $params['month1']]);
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();
        return redirect('/shop')->with(['year' => $params['year'], 'month' => $params['month']]);
    }

    // switch to shop login
    public function postSwitch(Request $request)
    {
        // logout
        Auth::guard('web')->logout();

        // client login
        $params = $request->all();
        $user = User::getUserByName($params['name']);        
        Auth::guard('web')->attempt(['name' => $user->name, 'password' => $user->password1]);

        Session::put('user_role', 'web');
        Session::save();

        return redirect('/');
    }

    // switch to shop invoice
    public function postShowInvoice(Request $request)
    {
        // logout
        Auth::guard('web')->logout();

        // client login
        $params = $request->all();
        $user = User::getUserByName($params['shop_name']);
        Auth::guard('web')->attempt(['name' => $user->name, 'password' => $user->password1]);

        // save session
        Session::put('user_role', 'web');
        Session::save();

        // show invoice
        $invoice_url = url('invoice') . '/' . str_replace('/', '', $user->remember_token);
        return redirect($invoice_url);
    }
}