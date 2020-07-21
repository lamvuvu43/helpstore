<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        // return Validator::make($data, [
        //     'username' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'phone' => ['required', 'max:10', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);

        $rules = [
            'username' => 'required|max:191', //unique:tenbang,tencot
            'email' => 'required|unique:users,email|max:255',
            'phone' => 'required|unique:users,phone|max:10',
            'password' => 'required|min:8|confirmed',
        ];
        $messages = [
            'username.required' => 'Họ tên không được trống',
            'email.unique' => 'Email đã tồn tại',
            'username.max' => 'Độ dài tối đa là 255',
            'email.required' => 'Email không được rỗng',
            'email.max' => 'Độ dài tối đa là 255',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed'=>"Mật khẩu không khớp"
        ];
        //        $this->validate($data,$rules,$messages);
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd('đã đến đây');
       User::create([
            'username' => $data['username'],
            'id_per' => '2',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
        ]);
        // auth()->login($user);
        return redirect()->route('home');
    }
}
