<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 17:53
 */

namespace App\Interfaces\Controllers\Notifications;

/**
 * Getting Sequences for
 * notifications
 * Interface NotificationsSequencesInterface
 * @package App\Interfaces\Controllers\Notifications
 */
interface NotificationsSequencesInterface
{
    /**
     * Getting all sequences for
     * notifications
     * @return mixed
     */
    public function actionGetSequences();

    /**
     * Getting sequence name
     * based on id
     * @param $sequence_id
     * @return mixed
     */
    public function actionGetSequenceName( $sequence_id );
}