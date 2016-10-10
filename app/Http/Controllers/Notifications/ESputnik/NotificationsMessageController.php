<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 18.08.2016
 * Time: 14:15
 */

namespace App\Http\Controllers\Notifications\ESputnik;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notifications\ESputnik\NotificationsConfigController as Config;

define('MESSAGE_URI', 'https://esputnik.com/api/v1/message/sms');

class NotificationsMessageController extends Controller
{
    /**
     * ESputnik config
     * @var array
     */
    private $config;

    /**
     * From whom we send message
     * @var String
     */
    private $message_from;

    /**
     * Message content
     * @var String
     */
    private $message_text;

    /**
     * Who is the message recipient
     * @var String
     */
    private $message_recipient;

    /**
     * Object of message
     * @var
     */
    private $message_object;

    /**
     * Getting config
     * NotificationsSMSController constructor.
     */
    public function __construct()
    {
        $this->config = Config::getConfig();
    }

    public function actionSendMessage() {

        $this->actionCollectData();
        $this->actionMakeRequest();
    }

    public function actionCollectData() {

        $this->message_from = 'reklama';
        $this->message_text = 'Test message!';
        $this->message_recipient = '380950948268';

        $json = new \stdClass();
        $json->text = $this->message_text;
        $json->from = $this->message_from;
        $json->phoneNumbers = array( $this->message_recipient );

        $this->message_object = $json;
    }

    private function actionMakeRequest() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
            $this->message_object
            )
        );

        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json', 'Content-Type: application/json'
            )
        );

        curl_setopt($ch, CURLOPT_URL, MESSAGE_URI);

        curl_setopt($ch,CURLOPT_USERPWD,
            $this->config['username'] . ':' . $this->config['password']
        );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!

        curl_exec($ch);

        curl_close($ch);
    }

}