<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Setting;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends AdminController
{

    public function __construct()
    {
        $this->platform = 'profile';
        $this->menu = 'profile';
        parent::__construct();
    }

    public function showEdit(Request $request)
    {
        $user_id = Auth::guard('admin')->user()->id;
        $this->view_datas['user'] = Admin::findById($user_id);
        $this->view_datas['db_date'] = Setting::getToday();
        $this->view_datas['enable_db_date'] = Setting::enableDBDate();
        return parent::showEditForm($request, 1);
    }

    public function postEdit(Request $request)
    {
        $params = $request->all();

        // update user information
        $user = Admin::findById($params['id']);
        $user->name = $params['name'];
        $user->email = $params['email'];
        if($params['password'] != ''){
            $user->password = bcrypt($params['password']);
            $user->remember_token = bcrypt($params['password']);
        }

        $user->save();

        // check db_date
        if(isset($params['enable_db_date'])){
            Setting::setToday($params['db_date'],1);
        }
        else {
            Setting::setToday('1900-01-31', 0);
        }

        return redirect('/admin/');
    }
}