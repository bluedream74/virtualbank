<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Illuminate\Http\Request;

class HomeController extends AdminController
{

    public function __construct()
    {
        $this->platform = 'home';
        $this->menu = 'home';
        parent::__construct();
    }

    public function index()
    {
        return parent::index();
    }
}
