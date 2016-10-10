<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 18:18
 */

namespace App\Interfaces\Controllers\Notifications;

/**
 * Getting config for service
 * Interface NotificationsConfigInterface
 * @package app\Interfaces\Controllers\Notifications
 */
interface NotificationsConfigInterface
{
    /**
     * Getting config
     * @return mixed
     */
    public static function getConfig();

}