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
use App\Models\Transaction;
use App\Models\CardType;
use App\Models\PaymentMethod;
use App\Models\Setting;
use DateTime;
use DateTimeZone;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Shop;
use App\Models\Merchant;


class TransactionController extends CustomerController
{
    protected $platform = 'customer';
    public $start_date = '';
    public $end_date = '';

    public function index()
    {
        Session::put('menu', 'home');

        // pagination length
        $this->view_datas['page_len'] = Setting::getPageLen();

        // date filter
        if(session('start_date')){
            $this->start_date = session('start_date');
            $this->end_date = session('end_date');
        }
        else {

            /*$start = Setting::getStartDate();
            $end = Setting::getEndDate();

            if($start != ''){
                $this->start_date = $start;
                $this->end_date = $end;
            }
            else{
                $this->start_date = date('Y-m-d', strtotime(' -1 month'));
                $this->end_date = date('Y/m/d');
            }*/

            $this->start_date = date('Y-m-d', strtotime(' -1 month'));
            $this->end_date = date('Y/m/d');

            $path_full = parse_url(url()->full());
            if(isset($path_full['query'])) {
                parse_str($path_full['query'], $params);
                if(sizeof($params) > 1) {
                    $this->start_date = $params['start_date'];
                    $this->end_date = $params['end_date'];
                }
            }                
        }    

        $this->view_datas['start_date'] = $this->start_date;
        $this->view_datas['end_date'] = $this->end_date;
        //Setting::setDates($this->start_date, $this->end_date);

        // get transaction list
        $list = Transaction::getAllByUser($this->start_date, $this->end_date, Auth::user());

        // get success count, amount
        $this->view_datas['success_count'] = Transaction::getTotalCount($list, '成功');
        $this->view_datas['success_amount'] = Transaction::getTotalAmount($list, '成功');

        // get refund count, amount
        $this->view_datas['refund_count'] = Transaction::getTotalCount($list, '返金完了');
        $this->view_datas['refund_amount'] = Transaction::getTotalAmount($list, '返金完了');

        // get CB count, amount
        $this->view_datas['cb_count'] = Transaction::getTotalCount($list, 'CB確定');
        $this->view_datas['cb_amount'] = Transaction::getTotalAmount($list, 'CB確定');

        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['page_len'], null, array('path' => url('/transaction')));      //  Transaction::orderBy('created_at', 'DESC')->paginate($this->view_datas['page_len']);
        $this->view_datas['card_type'] = CardType::all();
        $this->view_datas['payment_method'] = PaymentMethod::all();

        return view("{$this->platform}.transaction.index",  ['datas' => $this->view_datas]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function showDetail(Request $request, $id)
    {
        $this->view_datas['card_type'] = CardType::all();
        $this->view_datas['payment_method'] = PaymentMethod::all();
        $this->view_datas['transaction'] = Transaction::getDetail($id);

        return view("{$this->platform}.transaction.detail",  ['datas' => $this->view_datas]);
    }

    public function postPageLen(Request $request)
    {
        $params = $request->all();
        Setting::setPageLen($params['page_len']);

        $start_date = $params['start_date1'];
        $end_date = $params['end_date1'];
        return redirect('/transaction')->with(['start_date' => $start_date, 'end_date' => $end_date]);
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];

        return redirect('/transaction')->with(['start_date' => $start_date, 'end_date' => $end_date]);
    }
}