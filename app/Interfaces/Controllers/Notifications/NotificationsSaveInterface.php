<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 17:46
 */

namespace App\Interfaces\Controllers\Notifications;

/**
 * Notifications save
 * Validation of notification
 * Saving and updating
 * Interface NotificationsSaveInterface
 * @package app\Interfaces\Controllers\Notifications
 */
interface NotificationsSaveInterface
{
    /**
     * Saving an notification
     * @return mixed
     */
    public function actionSaveNotification();

    /**
     * Updating an exist notification
     * @param $id
     * @return mixed
     */
    public function actionUpdateNotificationById( $id );

    /**
     * Validating in notification exists
     * @return mixed
     */
    public function actionFindIfNotificationExists();
}