<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 18.08.2016
 * Time: 14:45
 */

namespace App\Http\Controllers\Notifications\ESputnik;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\ESputnik\NotificationsConfigController as Config;
use App\Http\Controllers\Notifications\NotificationsMethodController;
use App\Interfaces\Controllers\Notifications\NotificationsInterface;

use App\User;
use App\Models\Notifications\NotificationsModel;
use App\Models\Notifications\NotificationsParamsModel;

/**
 * Main Index for Notifications
 * eSputnik @Provider
 * Collecting data, sending Request, logging
 * Class NotificationsController
 * @package App\Http\Controllers\Notifications\ESputnik
 */
class NotificationsIndexController extends Controller implements NotificationsInterface
{
    /**
     * Getting URI
     * @var
     */
    private $request_url;

    /**
     * ESputnik config
     * @var array
     */
    private $config;

    /**
     * From whom we send email
     * @var String
     */
    private $recipient;

    /**
     * Request object
     * @var
     */
    private $_request;

    /**
     * eSputnik message id
     * @var
     */
    private $content_id;

    /**
     * Message params list
     * @var
     */
    private $params_list;

    /**
     * Message params
     * @var
     */
    private $params;

    /**
     * Getting config
     * NotificationsSMSController constructor.
     */
    public function __construct()
    {
        $this->config = Config::getConfig();
    }

    /**
     * Main function for sending requests
     * For Email & Message events
     * @param $user_id
     * @param $trigger_id
     */
    public function actionSendMessage( $user_id, $trigger_id ) {

        $types = $this->actionFindMessagesTypesForTrigger( $trigger_id );

        foreach( $types as $data ) {

            $type = $data->notification_type_id;

            $this->actionCollectDataForTrigger( $type, $trigger_id );
            $this->actionGenerateRequestURL( $this->content_id );
            $this->actionGetUserData( $user_id, $type );
            $this->actionCollectParams( $user_id );

            $this->actionGenerateMessage();
        }

        if( $user_id != 1 )
        {
            $this->actionMakeRequest();
        }

    }

    #private function action

    /**
     * Getting the type of trigger event
     * Might be Email | Message
     * @param $trigger_id
     * @return array|static[]
     */
    public function actionFindMessagesTypesForTrigger( $trigger_id ) {

        $data = NotificationsModel::where('notification_id', '=', $trigger_id)
            ->get(['notification_type_id']);

        return $data;
    }

    /**
     * Getting message params
     * For eSputnik logging
     * @param $user_id
     * @return array
     */
    public function actionCollectParams( $user_id ) {

        $params_id = explode( ",", $this->params_list );

        $result = array();

        foreach( $params_id as $param ) {

            $data = NotificationsParamsModel::where('id', '=', $param)
                ->first(['template_variable', 'method_name']);

            $result = array();

            $include_result = array(
                'key' => $data->template_variable,
                'value' => NotificationsMethodController::actionGetUserData( $data->method_name, $user_id ),
            );

            $result[] = $include_result;
        }

        return $result;
    }

    /**
     * Getting eSputnik message @id
     * Getting params in @format CSV
     * @param $type_id
     * @param $trigger_id
     * @return int
     */
    public function actionCollectDataForTrigger( $type_id, $trigger_id )
    {
        $data = NotificationsModel::where('notification_id', '=', $trigger_id)
            ->where('notification_type_id', '=', $type_id)
            ->first([
                'notification_request_message',
                'notification_params'
            ]);

        $this->content_id = $data->notification_request_message;
        $this->params_list = $data->notification_params;

        return 0;
    }

    /**
     * Generating of cURL URI
     * Based on eSputnik message @id
     * @param $content_id
     * @return int
     */
    public function actionGenerateRequestURL( $content_id ) {

        $this->request_url = 'https://esputnik.com/api/v1/message/' . $content_id . '/send';

        return 0;
    }

    /**
     * Getting data with @whom to send message
     * Might be Email @ex. test@test.test
     * Or be Message @ex. 380951111111
     * @param $user_id
     * @param $type
     * @return int
     */
    public function actionGetUserData( $user_id, $type ) {

        switch( $type ) {

            case '2':
                $recipient = User::where('id', '=', $user_id)
                    ->first(['email'])
                    ->email;
                break;

            case '3':
                $recipient = User::where('id', '=', $user_id)
                    ->first(['phone'])
                    ->phone;
                break;

            default:
                die('Invalid request type.');
        }

        $this->recipient = $recipient;

        return $recipient;
    }

    /**
     * Generate the body of the message
     * With Object type @notation
     * @param null $params
     * @return object
     */
    public function actionGenerateMessage( $params = null ) {

        $message = new \stdClass();
        $message->params = $params;
        $message->recipients = $this->recipient;

        $this->_request = $message;

        return $message;
    }

    /**
     * Making request to the
     * eSputnik service
     * @using cURL
     * @params Object type
     */
    public function actionMakeRequest() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                $this->_request
            )
        );

        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json', 'Content-Type: application/json'
            )
        );

        curl_setopt($ch, CURLOPT_URL, $this->request_url);

        curl_setopt($ch,CURLOPT_USERPWD,
            $this->config['username'] . ':' . $this->config['password']
        );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!

        curl_exec($ch);

        curl_close($ch);
    }

}