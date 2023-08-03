<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Transaction;
use App\Models\Merchant;
use App\Models\PayCycle;

use DateTime;
use DateTimeZone;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends AdminController
{

    public function __construct()
    {
        $this->platform = 'transaction';
        $this->menu = 'manage';
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
            $this->view_datas['transaction_id'] = $params['transaction_id'];
            $this->view_datas['t_id'] = $params['t_id'];
            $this->view_datas['merchant_id'] = $params['merchant_id'];
            $this->view_datas['shop_id'] = $params['shop_id'];
            $this->view_datas['merchant_id'] = $params['merchant_id'];
            $this->view_datas['shop_id'] = $params['shop_id'];
            $this->view_datas['status'] = $params['status'];
            $this->view_datas['agency_name'] = $params['agency_name'];
            $this->view_datas['card_number'] = $params['card_number'];
            $this->view_datas['card_holder'] = $params['card_holder'];
            $this->view_datas['tel'] = $params['tel'];
            $this->view_datas['pagelen'] = $params['pagelen'];
            $list = $this->searchTransaction($params);
        }
        else {

             // get transaction list
            $this->view_datas['start_date'] = '';
            $this->view_datas['end_date'] = '';
            $this->view_datas['transaction_id'] = '';
            $this->view_datas['t_id'] = '';
            $this->view_datas['merchant_id'] = '';
            $this->view_datas['shop_id'] = '';
            $this->view_datas['merchant_id'] = '';
            $this->view_datas['shop_id'] = '';
            $this->view_datas['status'] = '';
            $this->view_datas['agency_name'] = '';
            $this->view_datas['card_number'] = '';
            $this->view_datas['card_holder'] = '';
            $this->view_datas['tel'] = '';
            $this->view_datas['pagelen'] = 50;
            $list = Transaction::getList();
        }
        
        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['pagelen'], null, array('path' => url('/admin/transaction/')));
        
        // card result
        $cardResult = $this->getCardSearchResult($list);
        $this->view_datas['visa'] = $cardResult['visa'];
        $this->view_datas['master'] = $cardResult['master'];
        $this->view_datas['jcb'] = $cardResult['jcb'];
        $this->view_datas['amex'] = $cardResult['amex'];       
        
        // merchant, shop array
        $this->view_datas['merchants'] = Merchant::all();
        $this->view_datas['shops'] = Shop::all();
        $this->view_datas['paycycles'] = PayCycle::all();
                
        return parent::index();
    }

    // pagination
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // post search
    public function postSearch(Request $request)
    {
        $params = $request->all();

        $list = $this->searchTransaction($params);
        $params['list'] = $this->paginate($list, $params['pagelen'], null, array('path' => url('/admin/transaction')));

        // card result
        $cardResult = $this->getCardSearchResult($list);
        $params['visa'] = $cardResult['visa'];
        $params['master'] = $cardResult['master'];
        $params['jcb'] = $cardResult['jcb'];
        $params['amex'] = $cardResult['amex'];
        
        // merchant, shop array
        $params['merchants'] = Merchant::all();
        $params['shops'] = Shop::all();
        $params['paycycles'] = PayCycle::all();
        
        $this->view_datas = $params;
        return parent::index();
    }

    // search result
    public function searchTransaction($params)
    {
        return Transaction::getSearch($params);
    }

    // card result
    public function getCardSearchResult($list)
    {
        $t_count = [0,0,0,0,0];
        $t_amount = [0,0,0,0,0];
        $ss_count = [0,0,0,0,0];
        $ss_amount = [0,0,0,0,0];
        $ff_count = [0,0,0,0,0];
        $ff_amount = [0,0,0,0,0];
        $cc_count = [0,0,0,0,0];
        $cc_amount = [0,0,0,0,0];
        $cb_count = [0,0,0,0,0];
        $cb_amount = [0,0,0,0,0];
        $sms_count = [0,0,0,0,0];
        $sms_amount = [0,0,0,0,0];
        $sms_ss_count = [0,0,0,0,0];
        $banner_count = [0,0,0,0,0];
        $qr_count = [0,0,0,0,0];

        foreach($list as $transaction){

            $cardtype = $transaction->cardtype_id;

            $t_count[$cardtype]++;
            $t_amount[$cardtype]  +=  $transaction->amount;

            if($transaction->status == '成功'){
                $ss_count[$cardtype]++;
                $ss_amount[$cardtype] += $transaction->amount;
            }
            elseif($transaction->status == '失敗'){
                $ff_count[$cardtype]++;
                $ff_amount[$cardtype] += $transaction->amount;
            }
            elseif($transaction->status == '返金完了'){
                $cc_count[$cardtype]++;
                $cc_count[$cardtype] += $transaction->amount;
            }
            elseif($transaction->status == 'CB確定'){
                $cb_count[$cardtype]++;
                $cb_amount[$cardtype] += $transaction->amount;
            }

            if($transaction->sms_amount != 0){
                $sms_count[$cardtype]++;
                $sms_amount[$cardtype] += $transaction->sms_amount;

                if($transaction->status == '成功'){
                    $sms_ss_count[$cardtype]++;
                }
            }

            if($transaction->payment_method_id == 1)
                $banner_count[$cardtype]++;
            elseif($transaction->payment_method_id == 2)
                $qr_count[$cardtype]++;
        }

        $visa = json_encode(array(
            't_count' => $t_count[1],
            't_amount' => $t_amount[1],
            'ss_count' => $ss_count[1],
            'ss_amount' => $ss_amount[1],
            'ff_count' => $ff_count[1],
            'ff_amount' => $ff_amount[1],
            'cc_count' => $cc_count[1],
            'cc_amount' => $cc_amount[1],
            'cb_count' => $cb_count[1],
            'cb_amount' => $cb_amount[1],
            'sms_count' => $sms_count[1],
            'sms_amount' => $sms_amount[1],
            'sms_ss_count' => $sms_ss_count[1],
            'banner_count' => $banner_count[1],
            'qr_count' => $qr_count[1]
        ));

        $master = json_encode(array(
            't_count' => $t_count[2],
            't_amount' => $t_amount[2],
            'ss_count' => $ss_count[2],
            'ss_amount' => $ss_amount[2],
            'ff_count' => $ff_count[2],
            'ff_amount' => $ff_amount[2],
            'cc_count' => $cc_count[2],
            'cc_amount' => $cc_amount[2],
            'cb_count' => $cb_count[2],
            'cb_amount' => $cb_amount[2],
            'sms_count' => $sms_count[2],
            'sms_amount' => $sms_amount[2],
            'sms_ss_count' => $sms_ss_count[2],
            'banner_count' => $banner_count[2],
            'qr_count' => $qr_count[2]
        ));

        $jcb = json_encode(array(
            't_count' => $t_count[3],
            't_amount' => $t_amount[3],
            'ss_count' => $ss_count[3],
            'ss_amount' => $ss_amount[3],
            'ff_count' => $ff_count[3],
            'ff_amount' => $ff_amount[3],
            'cc_count' => $cc_count[3],
            'cc_amount' => $cc_amount[3],
            'cb_count' => $cb_count[3],
            'cb_amount' => $cb_amount[3],
            'sms_count' => $sms_count[3],
            'sms_amount' => $sms_amount[3],
            'sms_ss_count' => $sms_ss_count[3],
            'banner_count' => $banner_count[3],
            'qr_count' => $qr_count[3]
        ));

        $amex = json_encode(array(
            't_count' => $t_count[4],
            't_amount' => $t_amount[4],
            'ss_count' => $ss_count[4],
            'ss_amount' => $ss_amount[4],
            'ff_count' => $ff_count[4],
            'ff_amount' => $ff_amount[4],
            'cc_count' => $cc_count[4],
            'cc_amount' => $cc_amount[4],
            'cb_count' => $cb_count[4],
            'cb_amount' => $cb_amount[4],
            'sms_count' => $sms_count[4],
            'sms_amount' => $sms_amount[4],
            'sms_ss_count' => $sms_ss_count[4],
            'banner_count' => $banner_count[4],
            'qr_count' => $qr_count[4]
        ));

        $ret = array(
           'visa' => $visa, 'master' => $master, 'jcb' => $jcb, 'amex' => $amex
        );

        return $ret;
    }

    // create
    public function postCreate(Request $request)
    {
        $params = $request->all();

        $transaction_id = $params['trans_id'];
        $status = $params['status_new'];
        $memo = '';
        if(isset($params['memo'])){
            $memo = $params['memo'];
        }

        $transaction = Transaction::findById($transaction_id);
        if($transaction->child == 0) {

            // create a new
            $new_transaction = $transaction->replicate();
            $new_transaction->status = $status;
            $new_transaction->parent = $transaction->id;
            $new_transaction->memo = $memo;
            $new_transaction->save();

            $transaction->child = $new_transaction->id;
            $transaction->save();
        }

        $params['start_date'] = $params['s_start_date'];
        $params['end_date'] = $params['s_end_date'];
        $params['transaction_id'] = $params['s_transaction_id'];

        $params['t_id'] = '';
        $params['merchant_id'] = '';
        $params['shop_id'] = '';
        $params['merchant_id'] = '';
        $params['shop_id'] = '';
        $params['status'] = '';
        $params['agency_name'] = '';
        $params['card_number'] = '';
        $params['card_holder'] = '';
        $params['tel'] = '';

        $this->view_datas['t_id'] = '';
        $this->view_datas['merchant_id'] = '';
        $this->view_datas['shop_id'] = '';
        $this->view_datas['merchant_id'] = '';
        $this->view_datas['shop_id'] = '';
        $this->view_datas['status'] = '';
        $this->view_datas['agency_name'] = '';
        $this->view_datas['card_number'] = '';
        $this->view_datas['card_holder'] = '';
        $this->view_datas['tel'] = '';

        $this->view_datas['start_date'] = $params['start_date'];
        $this->view_datas['end_date'] = $params['end_date'];
        $this->view_datas['transaction_id'] = $params['transaction_id'];
        $list = $this->searchTransaction($params);

        $this->view_datas['pagelen'] = $params['pagelen'];
        $this->view_datas['list'] = $this->paginate($list, $this->view_datas['pagelen'], null, array('path' => url('/admin/transaction')));
        
        $cardResult = $this->getCardSearchResult($list);
        $this->view_datas['visa'] = $cardResult['visa'];
        $this->view_datas['master'] = $cardResult['master'];
        $this->view_datas['jcb'] = $cardResult['jcb'];
        $this->view_datas['amex'] = $cardResult['amex'];

        // merchant, shop array
        $this->view_datas['merchants'] = Merchant::all();
        $this->view_datas['shops'] = Shop::all();
        $this->view_datas['paycycles'] = PayCycle::all();
        
        return parent::index();
    }

    // delete
    public function postDelete(Request $request)
    {
        $params = $request->all();

        $transaction = Transaction::findById($params['transaction_id']);
        $parent_transaction = Transaction::findById($transaction->parent);
        $parent_transaction->child = 0;
        $parent_transaction->save();
        $transaction->delete();

        die(json_encode(['success'=>200]));
    }
}
