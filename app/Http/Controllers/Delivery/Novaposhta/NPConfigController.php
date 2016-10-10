<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 17.08.2016
 * Time: 15:18
 */

namespace App\Http\Controllers\Delivery\Novaposhta;

use App\Interfaces\Controllers\Delivery\Novaposhta\NPConfigInterface;

use App\Http\Controllers\Controller;
use LisDev\Delivery\NovaPoshtaApi2;

class NPConfigController extends Controller implements NPConfigInterface
{
    /**
     * Private constructor, so nobody else can instance it
     *
     */
    private function __construct(){}

    /**
     * Call this method to get singleton
     *
     * @return NovaPoshtaApi2
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = self::actionGetNovaPoshtaConfig();
        }

        return $instance;
    }

    /**
     * Getting instance Of NovaPoshta
     * @return NovaPoshtaApi2
     */
    public static function actionGetNovaPoshtaConfig()
    {
        $np = new NovaPoshtaApi2(
            '951c00869b04d8ede92bdfdf63e6f9f8',
            'ru', // Language of returning data: ru (default) | ua | en
            FALSE, // in error make Exception: FALSE (default) | TRUE
            'curl' // request type: curl (defalut) | file_get_content
        );

        return $np;
    }

}