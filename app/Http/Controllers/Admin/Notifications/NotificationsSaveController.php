<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.08.2016
 * Time: 14:54
 */

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Controllers\Notifications\NotificationsSaveInterface;

use App\Models\Notifications\NotificationsModel;

/**
 * Saving an event or update
 * @if exists event
 * Class NotificationsSaveController
 * @package App\Http\Controllers\Admin\Notifications
 */
class NotificationsSaveController extends Controller implements NotificationsSaveInterface
{
    // event
    private $event_id;

    // sequence
    private $sequence_id;

    // eSputnik message id
    private $message_id;

    // eSputnik params
    private $params;

    /**
     * Initialize params
     * NotificationsSaveController constructor.
     * @param Request $request
     */
    public function __construct( Request $request )
    {
        $this->event_id = $request->input('event_id');
        $this->sequence_id = $request->input('sequence_id');
        $this->message_id = $request->input('message_id');
        $this->params = $request->input('params');
    }

    /**
     * Main index for an action
     * Validating if notification exists
     * @if exists - update
     * @else - create
     */
    public function actionIndex() {

        // if notification exists
        $existence = $this->actionFindIfNotificationExists();

        // if not exists
        if( $existence === false )
        {
            // save an notification
            $this->actionSaveNotification();
        } else
        {
            // else update an notification
            $this->actionUpdateNotificationById( $existence );
        }

    }

    /**
     * Saving an notification
     */
    public function actionSaveNotification() {

        return NotificationsModel::create([
            'notification_id' => $this->event_id,
            'notification_type_id' => $this->sequence_id,
            'notification_request_message' => $this->message_id,
            'notification_params' => $this->params,
        ]);
    }

    /**
     * Updating an existing notification
     * @param $id
     * @return bool
     */
    public function actionUpdateNotificationById( $id ) {

        $object = NotificationsModel::find( $id );

        $object->notification_id = $this->event_id;
        $object->notification_type_id = $this->sequence_id;
        $object->notification_request_message = $this->message_id;
        $object->notification_params = $this->params;

        $object->save();

        return true;
    }

    /**
     * Validating if notification
     * Already exists
     * @return bool
     */
    public function actionFindIfNotificationExists() {

        $sequence_type = $this->sequence_id;
        $sequence_id = $this->event_id;

        $data = NotificationsModel::where( function( $query ) use ( $sequence_type, $sequence_id )
        {
            $query->where( 'notification_id', '=', $sequence_type )
                ->where( 'notification_type_id', '=', $sequence_id );
        })->first([
            'notification_params'
        ]);

        if( isset( $data->id ) )
        {
            return $data->id;
        } else
        {
            return false;
        }
    }

}