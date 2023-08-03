<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Session;


class AdminController extends Controller
{
    protected $admin;
    protected $platform = '' ;
    protected $menu = '' ;
    protected $class = 'Services';
    protected $view_datas;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("admin.{$this->platform}.index", ['datas'=>$this->view_datas]);
    }

    public function showCreateForm(Request $request)
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("admin.{$this->platform}.create", ['datas'=>$this->view_datas]);
    }

    public function showEditForm(Request $request, $id)
    {
        Session::put('menu', $this->menu);
        Session::put('platform', $this->platform);
        return view("admin.{$this->platform}.edit", ['datas'=>$this->view_datas]);
    }
}