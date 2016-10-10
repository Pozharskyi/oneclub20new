<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 17:42
 */

namespace App\Interfaces\Controllers\Notifications;

/**
 * Getting all notifications options
 * for any Event
 * Interface NotificationsOptionsInterface
 * @package app\Interfaces\Controllers\Notifications
 */
interface NotificationsOptionsInterface
{
    public function actionGetNotificationsOptions( $event_id );
}