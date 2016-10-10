<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 13.09.2016
 * Time: 16:47
 */

namespace App\Http\Controllers\User\Cabinet;

use App\Models\Subscribation\SubscribationTypeModel;
use App\Models\User\UserSubscribationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Session;

class UserSubscribationController
{
    /*
     * View user subscriptions
     */
    public function ActionIndex(){
        $obj_user_subscribations = $this->getUserSubscribations();

        $subscribations = $this->getAllSubscribations();

        $user_subscribations = [];

        foreach($obj_user_subscribations as $ous){
            $user_subscribations[$ous->subscribation_id] = '';
        }
        return view('user.cabinet.subscribation_form', [
            'user_subscribations'   =>  $user_subscribations,
            'subscribations'        =>  $subscribations
        ]);
    }

    /*
     * Get all subscriptions
     * TODO add status subscription (on, off). Add foreign key to UserSubscribations
     */

    public function getAllSubscribations(){
        $result = SubscribationTypeModel::with(['subscribation'])
            ->get();
        return $result;
    }

    /*
     * Get all subscriptions our user
     */
    public function getUserSubscribations(){
        $result = UserSubscribationModel::where('user_id', Auth::id())
            ->get();
        return $result;
    }

    /*
     * Update user subscriptions and view updated user subscriptions
     */
    public function updateUserSubscribations(Request $request){

        foreach($request->subscribation as $sub){
            $subAr[] = $sub;
        }

        $user = User::find(Auth::id());
        $user->subscribe()->sync($subAr);

        Session::flash('message', 'Данные сохранены');

        $obj_user_subscribations = $this->getUserSubscribations();

        $subscribations = $this->getAllSubscribations();

        $user_subscribations = [];

        foreach($obj_user_subscribations as $ous){
            $user_subscribations[$ous->subscribation_id] = '';
        }

        return view('user.cabinet.subscribation_form', [
            'user_subscribations'   =>  $user_subscribations,
            'subscribations'        =>  $subscribations
        ]);
    }
}