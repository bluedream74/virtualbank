<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Customer\CustomerController;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends CustomerController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showReset($token)
    {
        $user = User::getUserByToken($token);
        if($user){
            $this->view_datas['user_id'] = $user->id;
            return view('customer.auth.reset', ['datas' => $this->view_datas]);
        }

        return redirect('/');
    }

    public function postReset(Request $request)
    {
        $params = $request->all();

        $user = User::findById($params['id']);
        $user->password = bcrypt($params['password']);
        $user->save();

        return redirect('/thanks-reset');
    }

    public function showThanksReset()
    {
        return view('customer.auth.thanks-reset');
    }
}
