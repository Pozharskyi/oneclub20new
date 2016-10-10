<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 18.08.2016
 * Time: 14:11
 */

namespace App\Http\Controllers\Notifications\ESputnik;

use App\Interfaces\Controllers\Notifications\NotificationsConfigInterface;
use App\Http\Controllers\Controller;

/**
 * Class NotificationsConfigController
 * @package App\Http\Controllers\Notifications\ESputnik
 */
class NotificationsConfigController extends Controller implements NotificationsConfigInterface
{
    /**
     * Getting ESputnik config
     * @return array
     */
    public static function getConfig() {

        $username = 'v.kolokoltseva@oneclub.ua';
        $password = '123456';

        return array(
            'username' => $username,
            'password' => $password,
        );
    }

}