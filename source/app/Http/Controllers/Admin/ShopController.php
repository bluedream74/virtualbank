<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use DateTime;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\User;
use App\Models\CardTypeList;
use App\Models\PaymentMethodList;
use App\Models\ServiceTypeList;
use App\Models\Shop;
use App\Models\Merchant;
use App\Models\Setting;

class ShopController extends AdminController {

    public function __construct()
    {
        $this->platform = 'shop';
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
            $data = $params;
        }
        else {
            $data = array(
                'name' => '',
                's_name' => '',
                's_tel' => '',
                'member_id' => '',
                's_service' => '',
                's_paycycle' => '',
                's_status' => '',
                'start_date' => '',
                'end_date' => '',
                'mid' => '',
                'pagelen' => 50
            );
        }

        $list = Shop::getSearch($data);
        $this->view_datas['data'] = $data;
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/shop/')));
        return parent::index();
    }
        
    // pagination
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function showCreateForm(Request $request)
    {
        $this->view_datas['shops'] = Shop::getAll();
        $this->view_datas['merchants'] = Merchant::getAll();

        $last_id = 10001;
        if(User::all()->last() != null)
            $last_id = User::all()->last()->id + 10001;
        $this->view_datas['name'] = 's_' . $last_id;

        return parent::showCreateForm($request);
    }

    public function postCreate(Request $request)
    {
        $params = $request->all();

        $last_id = 10001;
        if(User::all()->last() != null)
            $last_id = User::all()->last()->id + 10001;
        $last_id = 's_' . $last_id;

        // create user
        $user = new User();
        $user->name = $last_id; //$params['name'];
        $user->username = $params['s_name'];
        $user->type = '2';
        $user->password1 = $this->generate_password(10);
        $user->password = bcrypt($user->password1);
        $user->remember_token = bcrypt($user->password);
        $user->save();

        // validation
        if(!isset($params['s_group_name']))
            $params['s_group_name'] = '';

        if(!isset($params['s_memo']))
            $params['s_memo'] = '';

        if(!isset($params['s_agency_fee']))
            $params['s_agency_fee'] = 0;

        if(!isset($params['s_agency_name']))
            $params['s_agency_name'] = '';

        if(!isset($params['s_manager_name']))
            $params['s_manager_name'] = '';

        if(!isset($params['s_manager_tel']))
            $params['s_manager_tel'] = '';

        if(!isset($params['s_manager_email']))
            $params['s_manager_email'] = '';

        // shop
        $shop = new Shop();
        $shop->user_id = $user->id;
        $shop->member_id = $params['member_id'];
        $shop->name = $last_id; //$params['name'];
        $shop->s_name = $params['s_name'];
        $shop->s_name_fu = $params['s_name_fu'];
        $shop->s_address = $params['s_address'];
        $shop->s_tel = $params['s_tel'];
        $shop->s_url = $params['s_url'];
        $shop->s_email = $params['s_email'];
        $shop->s_group_name = $params['s_group_name'];
        $shop->s_visa_fee = $params['s_visa_fee'];
        $shop->s_jcb_fee = $params['s_jcb_fee'];
        $shop->s_master_fee = $params['s_master_fee'];
        $shop->s_amex_fee = $params['s_amex_fee'];
        $shop->s_transaction_fee = $params['s_transaction_fee'];
        $shop->s_cancel_fee = $params['s_cancel_fee'];
        $shop->s_charge_fee = $params['s_charge_fee'];
        $shop->s_enter_fee = $params['s_enter_fee'];
        $shop->s_paycycle_id = $params['s_paycycle_id'];

        $shop->s_agency_name = $params['s_agency_name'];
        $shop->s_agency_fee = $params['s_agency_fee'];

        $shop->s_status = $params['s_status'];
        $shop->s_memo = $params['s_memo'];
        $shop->qrcode = $params['qrcode'];
        $shop->mid = $params['mid'];
        $shop->s_manager_name = $params['s_manager_name'];
        $shop->s_manager_tel = $params['s_manager_tel'];
        $shop->s_manager_email = $params['s_manager_email'];
        $shop->save();

        // service type
        if(isset($params['service_type']))
            ServiceTypeList::add($params['service_type'], $shop->id);

        // card type
        if(isset($params['card_type']))
            CardTypeList::add($params['card_type'], $shop->id);

        // change low fee of merchant
        $merchantObj = Merchant::getUserByName($shop->member_id);
        $merchant = Merchant::findById($merchantObj->id);
        $merchant->u_visa_fee_low = $params['s_visa_fee'];
        $merchant->u_jcb_fee_low = $params['s_jcb_fee'];
        $merchant->u_master_fee_low = $params['s_master_fee'];
        $merchant->u_amex_fee_low = $params['s_amex_fee'];
        $merchant->save();
        
        // save mid in setting
        Setting::setMid($shop->mid);

        $new_shop = Shop::getDetail($shop->id);
        return redirect('admin/shop/thanks')->with(['title'=>'新規店舗登録完了しました', 'shop'=>$new_shop]);
    }

    function generate_password( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    public function showEditForm(Request $request, $id)
    {
        $this->view_datas['shops'] = Shop::getAll();
        $this->view_datas['shop'] = Shop::getDetail($id);
        $this->view_datas['merchants'] = Merchant::getAll();

        // check if can change pay_cycle.
        $today = Setting::getToday();
        $str_date = substr($today, 8, 2);
        if($str_date == '01')
            $this->view_datas['enable_edit_cycle'] = true;
        else
            $this->view_datas['enable_edit_cycle'] = false;

        return parent::showEditForm($request, $id);
    }

    public function postEdit(Request $request)
    {
        $params = $request->all();

        // validation
        if(!isset($params['s_group_name']))
            $params['s_group_name'] = '';

        if(!isset($params['s_memo']))
            $params['s_memo'] = '';

        if(!isset($params['s_agency_fee']))
            $params['s_agency_fee'] = 0;

        if(!isset($params['s_agency_name']))
            $params['s_agency_name'] = '';

        if(!isset($params['s_manager_name']))
            $params['s_manager_name'] = '';

        if(!isset($params['s_manager_tel']))
            $params['s_manager_tel'] = '';

        if(!isset($params['s_manager_email']))
            $params['s_manager_email'] = '';

        // change
        $shop = Shop::findById($params['id']);
        $shop->member_id = $params['member_id'];
        $shop->s_name = $params['s_name'];
        $shop->s_name_fu = $params['s_name_fu'];
        $shop->s_address = $params['s_address'];
        $shop->s_tel = $params['s_tel'];
        $shop->s_url = $params['s_url'];
        $shop->s_email = $params['s_email'];
        $shop->s_group_name = $params['s_group_name'];
        $shop->s_visa_fee = $params['s_visa_fee'];
        $shop->s_master_fee = $params['s_master_fee'];
        $shop->s_amex_fee = $params['s_amex_fee'];
        $shop->s_jcb_fee = $params['s_jcb_fee'];
        $shop->s_transaction_fee = $params['s_transaction_fee'];
        $shop->s_cancel_fee = $params['s_cancel_fee'];
        $shop->s_charge_fee = $params['s_charge_fee'];
        $shop->s_enter_fee = $params['s_enter_fee'];
        $shop->mid = $params['mid'];

        if(isset($params['s_paycycle_id'])){
            $shop->s_paycycle_id = $params['s_paycycle_id'];
        }

        $shop->s_agency_name = $params['s_agency_name'];
        $shop->s_agency_fee = $params['s_agency_fee'];
        $shop->s_status = $params['s_status'];
        $shop->s_memo = $params['s_memo'];
        $shop->s_manager_name = $params['s_manager_name'];
        $shop->s_manager_tel = $params['s_manager_tel'];
        $shop->s_manager_email = $params['s_manager_email'];
        $shop->save();

        // service type
        if(isset($params['service_type']))
            ServiceTypeList::add($params['service_type'], $shop->id);
        else
            ServiceTypeList::removeAll($shop->id);

        // card type
        if(isset($params['card_type']))
            CardTypeList::add($params['card_type'], $shop->id);
        else
            CardTypeList::removeAll($shop->id);

        // update user
        $user = User::findById($shop->user_id);
        $user->username = $params['s_name'];
        $user->password1 = $params['password'];
        $user->password = bcrypt($params['password']);
        $user->remember_token = bcrypt($user->password);
        $user->save();

        // change low fee of merchant
        $merchantObj = Merchant::getUserByName($shop->member_id);
        $merchant = Merchant::findById($merchantObj->id);
        $merchant->u_visa_fee_low = $params['s_visa_fee'];
        $merchant->u_jcb_fee_low = $params['s_jcb_fee'];
        $merchant->u_master_fee_low = $params['s_master_fee'];
        $merchant->u_amex_fee_low = $params['s_amex_fee'];
        $merchant->save();

        $new_shop = Shop::getDetail($shop->id);
        return redirect('admin/shop/thanks')->with(['title'=>'店舗情報を変更しました', 'shop'=>$new_shop]);
    }

    public function showThanks(Request $request)
    {
        return view('admin.shop.thanks');
    }

    public function getDelete($id)
    {
        // delete user
        $shop = Shop::findById($id);
        $user = User::findById($shop->user_id);
        $user->delete();

        // delete shop
        if($shop->delete()){
            die(json_encode(['success'=>200]));
        } else {
            die(json_encode(['error'=>1]));
        }
    }

    public function saveQRCode(Request $request)
    {
        $params = $request->all();

        $user= Shop::getShopByName($params['name']);
        $shop = Shop::findById($user->id);
        $shop->qrcode = $params['qrcode'];
        $shop->save();

        die(json_encode(['success'=>200]));
    }

    // ----------------------------------------------------------------------------------------------------
    // search
    // ----------------------------------------------------------------------------------------------------

    public function search(Request $request)
    {
        // search options
        $name = $request->session()->get('name', '');
        $s_name = $request->session()->get('s_name', '');
        $s_tel = $request->session()->get('s_tel', '');
        $member_id = $request->session()->get('member_id', '');
        $s_service = $request->session()->get('s_service', '');
        $s_paycycle = $request->session()->get('s_paycycle', '');
        $s_status = $request->session()->get('s_status', '');
        $start_date = $request->session()->get('start_date', '');
        $end_date = $request->session()->get('end_date', '');
        $mid = $request->session()->get('mid', '');
        $pagelen = $request->session()->get('pagelen', '');

        $data = array(
            'name' => $name,
            's_name' => $s_name,
            's_tel' => $s_tel,
            'member_id' => $member_id,
            's_service' => $s_service,
            's_paycycle' => $s_paycycle,
            's_status' => $s_status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'mid' => $mid,
            'pagelen' => $pagelen
        );

        // search result
        $list = Shop::getSearch($data);
        $this->view_datas['data'] = $data;
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/shop/')));

        return parent::index($request);
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();

        return redirect('/admin/shop/search')
            ->with('name', $params['name'])
            ->with('s_name', $params['s_name'])
            ->with('s_tel', $params['s_tel'])
            ->with('member_id', $params['member_id'])
            ->with('s_service', $params['s_service'])
            ->with('s_paycycle', $params['s_paycycle'])
            ->with('s_status', $params['s_status'])
            ->with('start_date', $params['start_date'])
            ->with('end_date', $params['end_date'])
            ->with('mid', $params['mid'])
            ->with('pagelen', $params['pagelen']
        );
    }
}