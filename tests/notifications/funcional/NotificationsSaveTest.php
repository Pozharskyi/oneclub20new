<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 14:51
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsSaveTest extends TestCase
{
    public function testSavingNotification()
    {
        $notification = array(
            'event_id' => 1,
            'sequence_id' => 1,
            'message_id' => 1,
            'params' => '1,2,3',
        );

        $search = array(
            'notification_id' => 1,
            'notification_type_id' => 1,
            'notification_request_message' => 1,
            'notification_params' => '1,2,3',
        );

        $this->call('GET', '/admin/notifications/save', $notification);

        $this->seeInDatabase('dev_notifications_index', $search);
    }

    public function testUpdatingNotification()
    {
        $notification = array(
            'event_id' => 1,
            'sequence_id' => 1,
            'message_id' => 1,
            'params' => '1,3',
        );

        $search = array(
            'notification_id' => 1,
            'notification_type_id' => 1,
            'notification_request_message' => 1,
            'notification_params' => '1,3',
        );

        $this->call('GET', '/admin/notifications/save', $notification);

        $this->seeInDatabase('dev_notifications_index', $search);
    }

}