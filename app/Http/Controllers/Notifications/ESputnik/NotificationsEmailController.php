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

class NotificationsEmailController extends Controller
{


    /**
     * ESputnik config
     * @var array
     */
    private $config;

    /**
     * From whom we send email
     * @var String
     */
    private $email_from;

    /**
     * Email subject
     * @var String
     */
    private $email_subject;

    /**
     * Email text
     * @var String
     */
    private $email_text;

    /**
     * Email plain text
     * @var
     */
    private $email_plainText;

    /**
     * Recipients
     * @var
     */
    private $emails;

    /**
     * Email in object form
     * @var
     */
    private $email_object;

    /**
     * Getting config
     * NotificationsSMSController constructor.
     */
    public function __construct()
    {
        $this->config = Config::getConfig();
    }

    public function actionSendEmail() {

        $this->actionCollectData();
        $this->actionMakeRequest();
    }

    private function actionCollectData() {

        $this->email_from = '"oneclub.ua" <v.kolokoltseva@oneclub.ua>'; // отправитель в формате "Имя" <email@mail.com>
        $this->email_subject = 'Тест';
        $this->email_text = '<html><body><h1>Это просто тест</h1></body></html>';
        $this->email_plainText = 'Простой вид сообщения тест'; // вариант письма в виде простого текста
        $this->emails = array('serdiuk.oleksandr@gmail.com');

        $json = new \stdClass();
        $json->from = $this->email_from;
        $json->subject = $this->email_subject;
        $json->htmlText = $this->email_text;
        $json->plainText = $this->email_plainText;
        $json->emails = $this->emails;

        $this->email_object = $json;

    }

    private function actionMakeRequest() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                $this->email_object
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