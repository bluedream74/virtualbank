<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Customer\CustomerController;
use App\Models\Mailer;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends CustomerController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForgotForm()
    {
        Session::put('menu', 'login');
        return view('customer.auth.forgot');
    }

    public function postSendCode(Request $request)
    {
        $params = $request->all();
        $email = $params['email'];

        // get user
        $user = User::getUserByEmail($email);
        if($user){

            // reset email
            $reset_url = url('/reset/' . $user->remember_token);
            Mailer::sendResetEmail($user->email, $reset_url);

            // thanks forgot
            $forgot_url = url('/thanks-forgot');
            die(json_encode(['code'=>'200', 'url'=> $forgot_url ]));
        }
        else {
            die(json_encode(['code'=>'101']));
        }
    }

    public function showThanksForgot()
    {
        return view('customer.auth.thanks-forgot');
    }
}
