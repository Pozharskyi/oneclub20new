<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',

            // CUSTOM FIELDS
            'f_name' => 'required|max:255',
            'l_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'confirmation' => 'required',
            // END CUSTOM FIELDS
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User;

        $user->name = $data['f_name'] . ' ' . $data['l_name'];
        $user->email = $data['email'];
        $user->password = bcrypt( $data['password'] );

        $user->f_name = $data['f_name'];
        $user->l_name = $data['l_name'];
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];

        $user->save();

        UsersBonusesController::actionInsertIntoBonuses( $user->id );

        return $user;
    }
}
