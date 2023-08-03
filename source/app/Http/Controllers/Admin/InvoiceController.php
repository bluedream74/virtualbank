<?php

namespace App\Http\Controllers\Admin;


use DB;
use Session;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Merchant;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceController extends AdminController
{

    public function __construct()
    {
        $this->platform = 'invoice';
        $this->menu = 'invoice';
        parent::__construct();
    }

    public function index()
    {
        $this->platform = 'invoice';
        $this->menu = 'invoice';

        // url path
        $pagelen = 50;
        $params = array();
        $path_full = parse_url(url()->full());
        if(isset($path_full['query'])) {
            parse_str($path_full['query'], $params);
            $pagelen = $params['pagelen'];
        }

        $data = $this->searchInvoices($params);
        $this->view_datas = $data;
        $this->view_datas['list'] = $this->paginate($data['list'], $pagelen, null, array('path' => url('/admin/invoice')));
        return parent::index();
    }

    // pagination
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    
    // show detail
    public function getDetail($id)
    {
        $this->platform = 'invoice';
        $this->menu = 'invoice';

        //  RR payment period
        $invoice = Invoice::getDetail($id);
        $this->view_datas['invoice'] = $invoice;
        return view("admin.{$this->platform}.detail", ['datas'=>$this->view_datas]);
    }

    // search
    public function postSearch(Request $request)
    {
        $params = $request->all();

        $data = $this->searchInvoices($params);
        $this->view_datas = $data;
        $this->view_datas['list'] = $this->paginate($data['list'], $params['pagelen'], null, array('path' => url('/admin/invoice')));
        return parent::index();
    }

    // Search Invoice
    public function searchInvoices($params = null)
    {
        $data = $params;
        if($data == null) {
            $data = array(
                'start_date' => '',
                'end_date' => '',
                'start_output' => '',
                'end_output' => '',
                'invoice_id' => '',
                'merchant_id' => '',
                'shop_id' => '',
                'start_invoice' => '',
                'end_invoice' => '',
                'amount_min' => '',
                'amount_max' => '',
                'pay_cycle' => '',
                'shop_name' => '',
                'pagelen' => 50
            );
        }

        $arr_result = Invoice::getAll($params);
        
        // get values for fee, amount, count based on card
        $arr_shop = array();
        $data['shop_count'] = 0;
        $data['pay_amount'] = 0;
        $data['total_count'] = 0;
        $data['total_amount'] = 0;
        $data['ss_count'] = 0;
        $data['ss_amount'] = 0;
        $data['cc_count'] = 0;
        $data['cc_amount'] = 0;
        $data['cb_count'] = 0;
        $data['cb_amount'] = 0;
        $data['month_amount'] = 0;
        $data['transaction_fee'] = 0;
        $data['tf_fee'] = 0;
        $data['sms_fee'] = 0;
        $data['cc_fee'] = 0;
        $data['cb_fee'] = 0;
        $data['enter_fee'] = 0;
        $data['rr_amount'] = 0;
        $data['rr_fee'] = 0;
        $data['list'] = $arr_result;

        foreach($arr_result as $item){

            // check shop_id
            if(($item->shop_id != '') && !in_array($item->shop_id, $arr_shop))
                array_push($arr_shop, $item->shop_id);

            // pay_amount
            if($item->pay_amount > 0)
                $data['pay_amount'] += $item->pay_amount;

            // total_count
            $data['total_count'] += $item->transaction_count;
            $data['total_amount'] += $item->transaction_amount;
            $data['ss_count'] += $item->ss_count;
            $data['ss_amount'] += $item->ss_amount;
            $data['cc_count'] += $item->cc_count;
            $data['cc_amount'] += $item->cc_amount;
            $data['cb_count'] += $item->cb_amount;
            $data['cb_amount'] += $item->cb_amount;

            $data['month_amount'] += $item->month_fee;
            $data['transaction_fee'] += $item->transaction_fee;
            $data['tf_fee'] += $item->tf_fee;
            $data['sms_fee'] += $item->sms_fee;

            $data['cc_fee'] += $item->cc_fee;
            $data['cb_fee'] += $item->cb_fee;
            $data['enter_fee'] += $item->enter_fee;
            $data['rr_amount'] += $item->rr_amount;
            $data['rr_fee'] += $item->rr_pay;
        }

        $data['shop_count'] = sizeof($arr_shop);
        return $data;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // 精算CSV
    // -----------------------------------------------------------------------------------------------------------------

    public function showCSV()
    {
        $this->platform = 'invoice';
        $this->menu = 'invoice-csv';

        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);

        // url path
        $pagelen = 50;
        $params = array();
        $path_full = parse_url(url()->full());
        if(isset($path_full['query'])) {
            parse_str($path_full['query'], $params);
            $pagelen = $params['pagelen'];
            $data = $params;
        }
        else {
            $data = array(
                'output_date' => '',
                'bank' => 1,
                'pagelen' => 50
            );
        }

        $list = $this->getCSVList($data);
        $this->view_datas = $data;
        $this->view_datas['list'] = $this->paginate($list, $pagelen, null, array('path' => url('/admin/invoice/csv')));
        return view("admin.{$this->platform}.csv", ['datas'=>$this->view_datas]);
    }

    // 精算CSV Search
    public function postSearchCSV(Request $request)
    {
        $params = $request->all();
        if(!isset($params['output_date'])){
            $params['output_date'] = '';
        }

        $list = $this->getCSVList($params);
        $params['list'] = $this->paginate($list, $params['pagelen'], null, array('path' => url('/admin/invoice/csv')));
        $this->view_datas = $params;

        return view("admin.{$this->platform}.csv", ['datas'=>$this->view_datas]);
    }

    public function getCSVList($data)
    {
        $list = Merchant::all();
        foreach($list as $merchant){

            // '普通', '当座', '貯蓄
            switch($merchant->u_holdertype){
                case '普通':
                    $merchant->u_holdeertype_code = 1;
                    break;
                case '当座':
                    $merchant->u_holdeertype_code = 2;
                    break;
                case '貯蓄':
                    $merchant->u_holdeertype_code = 4;
                    break;
            }

            // ご入金予定日
            $merchant->amount = 0;
            $arr_invoices = Invoice::getAllByMerchant($merchant->name, $data['output_date']);
            foreach($arr_invoices as $invoice){
                $merchant->amount += $invoice->pay_amount;
            }
        }

        return $list;
    }
}
