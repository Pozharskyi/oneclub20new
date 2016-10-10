<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.08.2016
 * Time: 10:49
 */

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Notifications\NotificationsOptionsInterface;

use App\Models\Notifications\NotificationsTypeModel;

/**
 * Getting all options for Notifications
 * Based on @param $event_id
 * Class NotificationsGetOptionsController
 * @package App\Http\Controllers\Admin\Notifications
 */
class NotificationsOptionsController extends Controller implements NotificationsOptionsInterface
{
    /**
     * Getting all options for Event
     * Return All options for Event
     * Return an Event
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( $event_id ) {

        // getting all options for event
        $list = $this->actionGetNotificationsOptions( $event_id );

        // return blade view
        return view('admin.notifications.notifications_options', [
            'list' => $list,
            'event_id' => $event_id,
        ]);
    }

    /**
     * Getting Options based on Event
     * @param $event_id
     * @return \Illuminate\Support\Collection
     */
    public function actionGetNotificationsOptions( $event_id ) {

        $list = NotificationsTypeModel::withEvent( $event_id )
            ->get([
                'dev_notifications_types_list.id',
                'dev_notifications_types_list.notification_type',
                'dev_notifications_index.notification_request_message'
            ]);

        return $list;
    }

}