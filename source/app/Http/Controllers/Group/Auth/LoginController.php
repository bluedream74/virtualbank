<?php

namespace App\Http\Controllers\Group\Auth;

use Session;
use App\Http\Controllers\Group\CustomerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends CustomerController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/group/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest:group')->except('logout');
    }

    public function showLoginForm()
    {
        Session::put('menu', 'login');
        return view('group.auth.login');
    }

    //Custom guard for admin
    public function guard()
    {
        return Auth::guard('group');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/group/login');
    }
}



