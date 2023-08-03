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
use App\Models\Transaction;

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
        // check if pagination with search
        $params = array();
        $path_full = parse_url(url()->full());
        if(isset($path_full['query']))
            parse_str($path_full['query'], $params);
        
        if(sizeof($params) > 1) {

            // get transaction list
            $this->view_datas['start_date'] = $params['start_date'];
            $this->view_datas['end_date'] = $params['end_date'];
            $this->view_datas['shop_id'] = $params['shop_id'];
            $this->view_datas['pagelen'] = $params['pagelen'];
        }
        else {

             // get transaction list
            $this->view_datas['start_date'] = '';
            $this->view_datas['end_date'] = '';
            $this->view_datas['shop_id'] = '';
            $this->view_datas['pagelen'] = 50;
        }
        
        $list = $this->searchTransaction($this->view_datas); 
        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['pagelen'], null, array('path' => url('/group/transaction/')));
        
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
        $list = $this->searchTransaction($params);
        $params['list'] = $this->paginate($list, $params['pagelen'], null, array('path' => url('/group/transaction')));

        $this->view_datas = $params;
        return parent::index();
    }

    public function searchTransaction($params)
    {
        return Transaction::getSearchByGroup($params);
    }
}