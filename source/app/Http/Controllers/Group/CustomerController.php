<?php
/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/23/2018
 * Time: 1:01 PM
 */

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;

class CustomerController extends Controller
{
    protected $admin;
    protected $platform = 'grouup' ;
    protected $menu = '' ;
    protected $view_datas;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->group = Auth::guard('group')->user();
            return $next($request);
        });
    }

    public function index()
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("group.{$this->platform}.index", ['datas'=>$this->view_datas]);
    }

    public function showCreateForm(Request $request)
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("group.{$this->platform}.create", ['datas'=>$this->view_datas]);
    }

    public function showEditForm(Request $request, $id)
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("group.{$this->platform}.edit", ['datas'=>$this->view_datas]);
    }
}