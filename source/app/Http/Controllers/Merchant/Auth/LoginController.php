<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Merchant\CustomerController;

use Illuminate\Support\Facades\Auth;
use Session;
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

    protected $redirectTo = '/merchant/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest:merchant')->except('logout');
    }

    public function showLoginForm()
    {
        Session::put('menu', 'login');
        return view('merchant.auth.login');
    }

    //Custom guard for admin
    public function guard()
    {
        return Auth::guard('merchant');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/merchant/login');
    }
}



