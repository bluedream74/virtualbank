<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Models\Mailer;
use App\Models\User;
use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;

class RegisterController extends CustomerController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm($token, $name, $email)
    {
        Session::put('menu', 'login');

        $this->view_datas['name'] = $name;
        $this->view_datas['email'] = $email;
        return view('customer.auth.register', ['datas' => $this->view_datas]);
    }

    public function showSignup()
    {
        $this->view_datas['users'] = User::all();
        return view('customer.auth.signup',  ['datas' => $this->view_datas]);
    }

    public function showPreThanks(Request $request)
    {
        $params = $request->all();
        Mailer::sendRegisterEmail($params);
        return view('customer.auth.thanks');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // upload photo
        $photo_url = $this->uploadPhoto($data);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'password' => bcrypt($data['password']),
            'photo' => $photo_url,
            'remember_token' => bcrypt($data['password'])
        ]);
    }

    public function uploadPhoto($data)
    {
        // photo upload
        $base64_string = $data['photo_data'];
        $extension = explode('/', mime_content_type($base64_string))[1];

        $filename = $data['name']. '_' .time() . '.' . $extension;
        $output_file = storage_path('app/public/photo') . '/'. $filename;
        file_put_contents($output_file, file_get_contents($base64_string));

        // return image url
        $img_url = url('/') . '/source/storage/app/public/photo/' . $filename;
        return $img_url;
    }
}
