<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 14:08
 */

namespace App\Interfaces\Controllers\Notifications;

interface NotificationsInterface
{
    /**
     * Getting data about message
     * based on trigger
     * @param $trigger_id
     * @return mixed
     */
    public function actionFindMessagesTypesForTrigger( $trigger_id );

    /**
     * Getting user data based
     * on user and trigger type
     * @param $user_id
     * @param $type
     * @return mixed
     */
    public function actionGetUserData( $user_id, $type );

    /**
     * Generating body of the
     * notification message
     * @param null $params
     * @return mixed
     */
    public function actionGenerateMessage( $params = null );

    /**
     * Making request to the service
     * @return mixed
     */
    public function actionMakeRequest();

}