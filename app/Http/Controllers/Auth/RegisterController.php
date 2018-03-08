<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendUserVerificationEmail;

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
    protected $redirectTo = 'admin/dashboard';

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
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'confirmation_token' => md5(uniqid($data['email'], true) . time()),
        ]);
    }

    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendUserVerificationEmail($user));

        // Count Users
        $countUsers = User::count();
        if ($countUsers == 1) {
            // attach roles to first user
            $this->attachRoles($user);
            // Activate first user
            $this->activateFirst($user);
            // return view('auth/login');
            return redirect('/login')->with('custom_success', 'You have got all the super admin roles, login now.');
        } else {
            return view('auth/verification-msg');
        }
    }

    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();
        $user->is_active = 1;
        if ($user->save()) {
            return view('auth/email-confirmation', ['user' => $user]);
        }
    }

    /**
    * Attach all roles to first registered user.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function attachRoles($user)
    {
        $roles = Role::get()->pluck('id');
        $user = User::where('id', $user->id)->first();
        $user->roles()->attach($roles);
    }

    /**
    * Activate first registered user.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function activateFirst($user)
    {
        $user = User::where('id', $user->id)->first();
        $user->is_active = 1;
        $user->save();
    }
}
