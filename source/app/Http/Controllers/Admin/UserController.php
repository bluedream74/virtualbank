<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Merchant;
use DateTime;
use DateTimeZone;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends AdminController
{

    public function __construct()
    {
        $this->platform = 'user';
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
                'u_name' => '',
                'u_tel' => '',
                'u_email' => '',
                'u_holdername_fu' => '',
                'u_status' => '',
                'start_date' => '',
                'end_date' => '',
                'pagelen' => 50
            );    
        }

        $list = Merchant::getSearch($data);
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/user/')));
        $this->view_datas['data'] = $data;

        return parent::index();
    }
    
    // pagination
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // show shops
    public function showShops(Request $request, $id)
    {
        $this->view_datas['list'] = Shop::getAllByUser($id);
        return view("admin.{$this->platform}.shops", ['datas'=>$this->view_datas]);
    }

    public function showCreateForm(Request $request)
    {
        if(User::all()->last() != null)
            $last_id = User::all()->last()->id + 10001;
        else
            $last_id = 10001;

        $this->view_datas['name'] = 'u_' . $last_id;
        $this->view_datas['users'] = Merchant::getAll();
        return parent::showCreateForm($request);
    }

    public function postCreate(Request $request)
    {
        $params = $request->all();

        $last_id = 10001;
        if(User::all()->last() != null)
            $last_id = User::all()->last()->id + 10001;
        $last_id = 'u_' . $last_id;

        // create user
        $user = new User();
        $user->name = $last_id; //$params['name'];
        $user->username = $params['u_name'];
        $user->password1 = $this->generate_password(10);
        $user->password = bcrypt($user->password1);
        $user->remember_token = bcrypt($user->password);
        $user->save();

        // params
        if(!isset($params['u_url']))
            $params['u_url'] = '';
        if(!isset($params['u_email']))
            $params['u_email'] = '';
        if(!isset($params['u_memo']))
            $params['u_memo'] = '';

        if(!isset($params['u_director_name']))
            $params['u_director_name'] = '';
        if(!isset($params['u_director_name_fu']))
            $params['u_director_name_fu'] = '';
        if(!isset($params['u_director_tel']))
            $params['u_director_tel'] = '';
        if(!isset($params['u_director_address']))
            $params['u_director_address'] = '';

        // merchant
        $merchant = new Merchant();
        $merchant->user_id = $user->id;
        $merchant->name = $last_id; //$params['name'];
        $merchant->u_name = $params['u_name'];
        $merchant->u_name_fu = $params['u_name_fu'];
        $merchant->u_tel = $params['u_tel'];
        $merchant->u_address = $params['u_address'];
        $merchant->u_email = $params['u_email'];
        $merchant->u_url = $params['u_url'];
        $merchant->u_banktype = $params['u_banktype'];
        $merchant->u_bankcode = $params['u_bankcode'];
        $merchant->u_branch = $params['u_branch'];
        $merchant->u_branchcode = $params['u_branchcode'];
        $merchant->u_holdernumber = $params['u_holdernumber'];
        $merchant->u_holdertype = $params['u_holdertype'];
        $merchant->u_holdername_sei = $params['u_holdername_sei'];
        $merchant->u_holdername_mei = '';
        $merchant->u_holdername_fu_sei = $params['u_holdername_fu_sei'];
        $merchant->u_holdername_fu_mei = '';
        $merchant->u_status = $params['u_status'];
        $merchant->qrcode =  $params['qrcode'];
        $merchant->u_memo = $params['u_memo'];

        $merchant->u_director_name =  $params['u_director_name'];
        $merchant->u_director_name_fu =  $params['u_director_name_fu'];
        $merchant->u_director_tel =  $params['u_director_tel'];
        $merchant->u_director_address =  $params['u_director_address'];

        $merchant->save();

        $merchant->password1 = $user->password1;
        return redirect('admin/user/thanks')->with(['title'=>'新規加盟店登録完了しました', 'user'=>$merchant]);
    }

    function generate_password( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    public function showEditForm(Request $request, $id)
    {
        $this->view_datas['list'] = Merchant::getAll();
        $this->view_datas['user'] = Merchant::getDetail($id);
        return parent::showEditForm($request, $id);
    }

    public function postEdit(Request $request)
    {
        $params = $request->all();

        if(!isset($params['u_url']))
            $params['u_url'] = '';
        if(!isset($params['u_email']))
            $params['u_email'] = '';
        if(!isset($params['u_memo']))
            $params['u_memo'] = '';

        if(!isset($params['u_director_name']))
            $params['u_director_name'] = '';
        if(!isset($params['u_director_name_fu']))
            $params['u_director_name_fu'] = '';
        if(!isset($params['u_director_tel']))
            $params['u_director_tel'] = '';
        if(!isset($params['u_director_address']))
            $params['u_director_address'] = '';

        $merchant = Merchant::findById($params['id']);
        $merchant->u_name = $params['u_name'];
        $merchant->u_name_fu = $params['u_name_fu'];
        $merchant->u_tel = $params['u_tel'];
        $merchant->u_address = $params['u_address'];
        $merchant->u_email = $params['u_email'];
        $merchant->u_url = $params['u_url'];
        $merchant->u_banktype = $params['u_banktype'];
        $merchant->u_bankcode = $params['u_bankcode'];
        $merchant->u_branch = $params['u_branch'];
        $merchant->u_branchcode = $params['u_branchcode'];
        $merchant->u_holdernumber = $params['u_holdernumber'];
        $merchant->u_holdertype = $params['u_holdertype'];
        $merchant->u_holdername_sei = $params['u_holdername_sei'];
        $merchant->u_holdername_mei = '';
        $merchant->u_holdername_fu_sei = $params['u_holdername_fu_sei'];
        $merchant->u_holdername_fu_mei = '';
        $merchant->u_status = $params['u_status'];
        $merchant->u_memo = $params['u_memo'];

        $merchant->u_director_name =  $params['u_director_name'];
        $merchant->u_director_name_fu =  $params['u_director_name_fu'];
        $merchant->u_director_tel =  $params['u_director_tel'];
        $merchant->u_director_address =  $params['u_director_address'];

        $merchant->save();

        // update user's password
        $user = User::findById($merchant->user_id);
        $user->username = $params['u_name'];
        $user->password1 = $params['password1'];
        $user->password = bcrypt($user->password1);
        $user->remember_token = bcrypt($user->password);
        $user->save();

        $merchant->password1 = $params['password1'];
        return redirect('admin/user/thanks')->with(['title'=>'加盟店情報を変更しました', 'user'=>$merchant]);
    }

    public function showThanks(Request $request)
    {
        return view('admin.user.thanks');
    }

    public function getDelete($id)
    {
        $merchant = Merchant::findById($id);

        // user delete
        $user = User::findById($merchant->user_id);
        $user->delete();

        // merchant delete
        if($merchant->delete()){
            die(json_encode(['success'=>200]));
        } else {
            die(json_encode(['error'=>1]));
        }
    }

    public function saveQRCode(Request $request)
    {
        $params = $request->all();

        $user = Merchant::getUserByName($params['name']);
        $merchant = Merchant::findById($user->id);
        $merchant->qrcode = $params['qrcode'];
        $merchant->save();

        die(json_encode(['success'=>200]));
    }

    // ----------------------------------------------------------------------------------------------------
    // search
    // ----------------------------------------------------------------------------------------------------

    public function postSearch(Request $request)
    {
        $params = $request->all();
        return redirect('/admin/user/search')
            ->with('name', $params['name'])
            ->with('u_name', $params['u_name'])
            ->with('u_tel', $params['u_tel'])
            ->with('u_email', $params['u_email'])
            ->with('u_holdername_fu', $params['u_holdername_fu'])
            ->with('u_status', $params['u_status'])
            ->with('start_date', $params['start_date'])
            ->with('end_date', $params['end_date'])
            ->with('pagelen', $params['pagelen']
        );
    }

    public function search(Request $request)
    {
        // search options
        $name = $request->session()->get('name', '');
        $u_name = $request->session()->get('u_name', '');
        $u_tel = $request->session()->get('u_tel', '');
        $u_email = $request->session()->get('u_email', '');
        $u_holdername_fu = $request->session()->get('u_holdername_fu', '');
        $u_status = $request->session()->get('u_status', '');
        $start_date = $request->session()->get('start_date', '');
        $end_date = $request->session()->get('end_date', '');
        $pagelen = $request->session()->get('pagelen', '');

        $data = array(
            'name' => $name,
            'u_name' => $u_name,
            'u_tel' => $u_tel,
            'u_email' => $u_email,
            'u_holdername_fu' => $u_holdername_fu,
            'u_status' => $u_status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'pagelen' => $pagelen
        );

        // search result
        $list = Merchant::getSearch($data);
        $this->view_datas['list'] = $this->paginate($list, $data['pagelen'], null, array('path' => url('/admin/user/')));
        $this->view_datas['data'] = $data;

        return parent::index($request);
    }
}
