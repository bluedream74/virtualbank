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
use Symfony\Component\HttpFoundation\Request;
use Validator;
use Session;
use App;
use App\Models\Transaction;
use DateTime;
use DateTimeZone;
use App\Models\User;
use App\Models\Shop;

class TransactionController extends CustomerController
{
    public function __construct()
    {
        $this->platform = 'transaction';
        $this->menu = 'transaction';
        parent::__construct();
    }

    public function index()
    {
        $this->view_datas['start_date'] = '';
        $this->view_datas['end_date'] = '';
        $this->view_datas['list'] = $this->searchTransaction('', '');
        return parent::index();
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();

        // search
        $this->view_datas['start_date'] = $params['start_date'];
        $this->view_datas['end_date'] = $params['end_date'];
        $this->view_datas['list'] = $this->searchTransaction($params['start_date'], $params['end_date']);
        return parent::index();
    }

    public function getShopTransaction()
    {
        Session::put('menu', 'transaction-shop');

        $this->view_datas['start_date'] = '';
        $this->view_datas['end_date'] = '';
        $this->view_datas['list'] = $this->searchTransaction('', '', 'shop');
        return view("merchant.{$this->platform}.shop", ['datas'=>$this->view_datas]);
    }

    public function postShopSearch(Request $request)
    {
        $params = $request->all();

        // search
        Session::put('menu', 'transaction-shop');

        $this->view_datas['start_date'] = $params['start_date'];
        $this->view_datas['end_date'] = $params['end_date'];
        $this->view_datas['list'] = $this->searchTransaction($params['start_date'], $params['end_date'], 'shop');
        return view("merchant.{$this->platform}.shop", ['datas'=>$this->view_datas]);
    }

    public function searchTransaction($start_date, $end_date, $type = 'merchant')
    {
        // dates
        if($start_date == '')
            $start_date = '1900-01-01';
        if($end_date == '')
            $end_date = '9999-01-01';

        if($type == 'merchant')
            return Transaction::getAllByUser($start_date, $end_date,  Auth::guard('merchant')->user());

        // get all transactions of shops in merchant
        $shop_list = Shop::getAllNamesByUser(Auth::guard('merchant')->user()->name);
        return Transaction::getAllByUser($start_date, $end_date,  Auth::guard('merchant')->user(), $shop_list);
    }
}