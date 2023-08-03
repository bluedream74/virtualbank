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
use App\Models\Shop;
use App\Models\Group;
use App\Models\Merchant;
use App\Models\Setting;

class GroupController extends AdminController {

    public function __construct()
    {
        $this->platform = 'group';
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
                'g_name' => '',
                'g_status' => '',
                'g_kind' => '',
                'merchant_id' => '',
                'shop_id' => '',
                'shop_name' => '',
                'start_date' => '',
                'end_date' => '',
                'pagelen' => 50
            );
        }

        $list = Group::getSearch($data);
        $this->view_datas['data'] = $data;
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/group/')));
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
        $this->view_datas['list'] = Group::getAll();
        return parent::showCreateForm($request);
    }

    public function postCreate(Request $request)
    {
        $params = $request->all();

        $last_id = 10001;
        if(User::all()->last() != null)
            $last_id = User::all()->last()->id + 10001;
        $last_id = 'g_' . $last_id;

        // create user
        $user = new User();
        $user->name = $last_id;
        $user->username = $params['g_name'];
        $user->type = '3';
        $user->password1 = $this->generate_password(10);
        $user->password = bcrypt($user->password1);
        $user->remember_token = bcrypt($user->password);
        $user->save();

        // group
        $group = new Group();
        $group->user_id = $user->id;
        $group->name = $last_id;
        $group->g_name = $params['g_name'];
        $group->g_name_fu = $params['g_name_fu'];
        $group->g_status = $params['g_status'];
        $group->g_kind = $params['g_kind'];
        $group = $this->getShoplist($params['g_shoplist'], $group);
        
        $group->g_agency_tel = (isset($params['g_agency_tel'])) ? $params['g_agency_tel'] : '';
        $group->g_agency_email = (isset($params['g_agency_email'])) ? $params['g_agency_email'] : '';
        $group->g_agency_name = (isset($params['g_agency_name'])) ? $params['g_agency_name'] : '';
        $group->g_agency_name_fu = (isset($params['g_agency_name_fu'])) ? $params['g_agency_name_fu'] : '';
        $group->g_thanks_email1 = (isset($params['g_thanks_email1'])) ? $params['g_thanks_email1'] : '';
        $group->g_thanks_email2 = (isset($params['g_thanks_email2'])) ? $params['g_thanks_email2'] : '';
        $group->g_thanks_email3 = (isset($params['g_thanks_email3'])) ? $params['g_thanks_email3'] : '';
        $group->g_memo = (isset($params['g_memo'])) ? $params['g_memo'] : '';
        $group->save();
      
        $new_group = Group::getDetail($group->id);
        return redirect('admin/group/thanks')->with(['title'=>'新規グループ登録完了しました', 'group'=>$new_group]);
    }

    public function showEditForm(Request $request, $id)
    {
        $this->view_datas['list'] = Group::getAll();
        $this->view_datas['group'] = Group::getDetail($id);

        return parent::showEditForm($request, $id);
    }

    public function postEdit(Request $request)
    {
        $params = $request->all();

        // update group
        $group = Group::findById($params['id']);
        $group->g_name = $params['g_name'];
        $group->g_name_fu = $params['g_name_fu'];
        $group->g_status = $params['g_status'];
        $group->g_kind = $params['g_kind'];
        $group = $this->getShoplist($params['g_shoplist'], $group);

        $group->g_agency_tel = (isset($params['g_agency_tel'])) ? $params['g_agency_tel'] : '';
        $group->g_agency_email = (isset($params['g_agency_email'])) ? $params['g_agency_email'] : '';
        $group->g_agency_name = (isset($params['g_agency_name'])) ? $params['g_agency_name'] : '';
        $group->g_agency_name_fu = (isset($params['g_agency_name_fu'])) ? $params['g_agency_name_fu'] : '';
        $group->g_thanks_email1 = (isset($params['g_thanks_email1'])) ? $params['g_thanks_email1'] : '';
        $group->g_thanks_email2 = (isset($params['g_thanks_email2'])) ? $params['g_thanks_email2'] : '';
        $group->g_thanks_email3 = (isset($params['g_thanks_email3'])) ? $params['g_thanks_email3'] : '';
        $group->g_memo = (isset($params['g_memo'])) ? $params['g_memo'] : '';
        $group->save();

        // update user
        $user = User::findById($group->user_id);
        $user->username = $params['g_name'];
        $user->save();

        $new_group = Group::getDetail($group->id);
        return redirect('admin/group/thanks')->with(['title'=>'グループ情報を変更しました', 'group'=>$new_group]);
    }

    public function showThanks(Request $request)
    {
        return view('admin.group.thanks');
    }

    public function getDelete($id)
    {
        // delete user
        $group = Group::findById($id);
        $user = User::findById($group->user_id);
        $user->delete();

        // delete group
        if($group->delete()){
            die(json_encode(['success'=>200]));
        } else {
            die(json_encode(['error'=>1]));
        }
    }

    // ----------------------------------------------------------------------------------------------------
    // search
    // ----------------------------------------------------------------------------------------------------

    public function search(Request $request)
    {
        // search options
        $name = $request->session()->get('name', '');
        $g_name = $request->session()->get('g_name', '');       
        $g_status = $request->session()->get('g_status', '');
        $g_kind = $request->session()->get('g_kind', '');
        $merchant_id = $request->session()->get('merchant_id', '');
        $shop_id = $request->session()->get('shop_id', '');
        $shop_name = $request->session()->get('shop_name', '');
        $start_date = $request->session()->get('start_date', '');
        $end_date = $request->session()->get('end_date', '');
        $pagelen = $request->session()->get('pagelen', '');

        $data = array(
            'name' => $name,
            'g_name' => $g_name,
            'g_status' => $g_status,
            'g_kind' => $g_kind,
            'merchant_id' => $merchant_id,
            'shop_id' => $shop_id,
            'shop_name' => $shop_name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'pagelen' => $pagelen
        );

        // search result
        $list = Group::getSearch($data);
        $this->view_datas['data'] = $data;
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/group/')));

        return parent::index($request);
    }

    public function postSearch(Request $request)
    {
        $params = $request->all();

        return redirect('/admin/group/search')
            ->with('name', $params['name'])
            ->with('g_name', $params['g_name'])
            ->with('g_status', $params['g_status'])
            ->with('g_kind', $params['g_kind'])
            ->with('merchant_id', $params['merchant_id'])
            ->with('shop_id', $params['shop_id'])
            ->with('shop_name', $params['shop_name'])
            ->with('start_date', $params['start_date'])
            ->with('end_date', $params['end_date'])
            ->with('pagelen', $params['pagelen']
        );
    }

    // ----------------------------------------------------------------------------------------------------
    // showShops
    // ----------------------------------------------------------------------------------------------------
    
    public function showShops($group_id)
    {
        Session::put('platform', 'group');
        
        $this->view_datas['list'] = Group::getAllShopByGroup($group_id);
        return view("admin.{$this->platform}.shops", ['datas'=>$this->view_datas]);
    }

    // ----------------------------------------------------------------------------------------------------
    // showMerchants
    // ----------------------------------------------------------------------------------------------------
    
    public function showMerchants($group_id)
    {
        Session::put('platform', 'group');

        $this->view_datas['list'] = Group::getAllMerchantByGroup($group_id);
        return view("admin.{$this->platform}.merchants", ['datas'=>$this->view_datas]);
    }

    // ----------------------------------------------------------------------------------------------------
    // generate_password
    // ----------------------------------------------------------------------------------------------------

    public function generate_password( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    // ----------------------------------------------------------------------------------------------------
    // getShoplist
    // ----------------------------------------------------------------------------------------------------

    public function getShoplist($shoplist, $group)
    {
        $arr_shop = array();
        $arr_shopnames = array();
        $arr_merchant = array();

        $list = explode(PHP_EOL, $shoplist);
        foreach($list as $shopname){
            $shop = Shop::getShopInfoByName($shopname);

            if($shop && !in_array($shopname, $arr_shop)){
                array_push($arr_shop, $shopname);
                array_push($arr_shopnames, $shop->s_name);

                if(!in_array($shop->member_id, $arr_merchant))
                    array_push($arr_merchant, $shop->member_id);
            }
        }

        $group->g_shopcount = sizeof($arr_shop);
        $group->g_shoplist = implode(PHP_EOL, $arr_shop);
        $group->g_shopnamelist = implode(',', $arr_shopnames);
        $group->g_merchantcount = sizeof($arr_merchant);
        $group->g_merchantlist = implode(PHP_EOL, $arr_merchant);
        return $group;
    }
}