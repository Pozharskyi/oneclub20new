<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.08.2016
 * Time: 13:52
 */

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\User;

/**
 * Getting notification data
 * with @method
 * Class NotificationsMethodController
 * @package App\Http\Controllers\Notifications
 */
class NotificationsMethodController extends Controller
{
    /**
     * Getting data based on user and method
     * @param $method
     * @param $user_id
     * @return mixed
     */
    public static function actionGetUserData( $method, $user_id ) {

        switch( $method ) {

            case 'getFullName':

                $data = User::where('id', '=', $user_id)
                    ->first(['name']);

                $result = $data->name;

                break;

            case 'getFirstName':

                $data = User::where('id', '=', $user_id)
                    ->first(['f_name']);

                $result = $data->f_name;

                break;

            case 'getLastName':

                $data = User::where('id', '=', $user_id)
                    ->first(['l_name']);

                $result = $data->l_name;

                break;

            default:
                return false;
        }

        return $result;
    }

}