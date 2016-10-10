<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
        /*
        $user = User::create([
            'name' => $data['f_name'] . ' ' . $data['l_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

            // CUSTOM FIELDS
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            // END CUSTOM FIELDS
        ]);
        */
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
