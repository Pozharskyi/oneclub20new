<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 18:14
 */

namespace App\Interfaces\Controllers\Delivery\Novaposhta;

/**
 * Config interface for
 * Integration with Nova Poshta
 * Interface NPConfigInterface
 * @package app\Interfaces\Controllers\Delivery\Novaposhta
 */
interface NPConfigInterface
{
    /**
     * Getting an instance of config
     * @pattern Singleton
     * @return mixed
     */
    public static function getInstance();

    /**
     * Getting config
     * @return mixed
     */
    public static function actionGetNovaPoshtaConfig();
}