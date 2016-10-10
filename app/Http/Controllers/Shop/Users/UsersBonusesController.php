<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 31.08.2016
 * Time: 12:55
 */

namespace App\Http\Controllers\Shop\Users;

use App\Http\Controllers\Controller;
use App\Models\User\UsersBonusesModel;

/**
 * Getting all user bonuses
 * For checkout
 * Class UsersBonusesController
 * @package App\Http\Controllers\Shop\Users
 */
class UsersBonusesController extends Controller
{
    /**
     * Getting all user bonuses
     * based on user
     * @param $user_id
     * @return int
     */
    public static function actionGetUserBonuses( $user_id )
    {
        $user = UsersBonusesModel::where( 'user_id', '=', $user_id )
            ->first(['bonuses_amount']);

        if( count( $user ) == 0 )
        {
            // if no records found
            return 0;
        } else
        {
            // else get bonuses
            return $user->bonuses_amount;
        }
    }

}