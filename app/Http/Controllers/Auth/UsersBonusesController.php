<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 19:57
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\UsersBonusesModel;

class UsersBonusesController extends Controller
{
    /**
     * Inserting into bonuses
     * @param $user_id
     * @return UsersBonusesModel
     */
    public static function actionInsertIntoBonuses( $user_id )
    {
        return UsersBonusesModel::create([
            'user_id' => $user_id,
            'bonuses_amount' => 0,
        ]);
    }

}