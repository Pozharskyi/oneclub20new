<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 31.08.2016
 * Time: 11:14
 */

namespace App\Http\Controllers\User\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Session;

class UserInfoController extends Controller
{
    /*
     *   User Info Controller
     */

    /*
     * View user info and form to edit user info
     */
    public function ActionIndex(){
        if (!Auth::check()) {
            return redirect('login');
        }

        $data = $this->getUserInfo();
        $delivery = UserDeliveryController::getUserDeliveryList();

        return view('user.cabinet.my_info',['data'=> $data, 'delivery' => $delivery]);
    }

    /*
     * validate and update user info
     * incoming request PUT data
    */
    public function updateUserInfo(Request $request){

        $data = [
            'f_name'        =>  $request->f_name,
            'l_name'        =>  $request->l_name,
            'email'         =>  $request->email,
            'gender'        =>  $request->gender,
            'date_of_birth' =>  $request->date_of_birth,
            'phone'         =>  $request->phone
        ];

        /*
         * TODO add/edit rules to validate
         */
        $validator = Validator::make($data, [
            'f_name'        =>  'required|min:2|max:255|string',
            'l_name'        =>  'required|max:255|string',
            'email'         =>  'required|email|unique:users,email,'.Auth::id(),
            'gender'        =>  'required|in:Male,Female',
            'date_of_birth' =>  'date_format:Y-m-d',
            'phone'         =>  'required',
            ]
        );

        if (!$validator->fails()) {
            /*
            * Save
            */
            $this->updateUserInfoToDB($data);

            Session::flash('message', 'Данные сохранены');
        }
        /*
         * get user address
         */
        $delivery = UserDeliveryController::getUserDeliveryList();

        return view('user.cabinet.my_info',[
            'data'      => $data,
            'delivery'  => $delivery
        ])
        ->withErrors($validator);
    }

    /*
     * Get user info
     */
    public function getUserInfo(){
        $data = User::where('id',Auth::id())
            ->get([
                'f_name',
                'l_name',
                'email',
                'phone',
                'gender',
                'date_of_birth'
            ]);
        return $data[0];
    }

    /*
     * Update user info
     */
    public function updateUserInfoToDB($data){
        $user = User::findOrFail(Auth::id());
        $user->update($data);
    }
}