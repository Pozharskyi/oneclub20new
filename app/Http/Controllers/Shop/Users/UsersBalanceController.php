<?php

namespace App\Http\Controllers\Shop\Users;

use App\Models\User\UserBalanceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersBalanceController extends Controller
{
    public static function actionGetUsersBalance($userId)
    {
        $balance = UserBalanceModel::where('user_id',$userId)
            ->first(['balance_amount']);

        if(!$balance){
            return 0;
        }
        return $balance->balance_amount;
    }
}
