<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 18:03
 */

namespace App\Interfaces\Controllers\Auth\Social;

/**
 * Social Auth config
 * Interface SocialConfigDataInterface
 * @package app\Interfaces\Controllers\Auth\Social
 */
interface SocialConfigDataInterface
{
    /**
     * Getting config based on
     * provider we selected
     * @param $provider
     * @param $code
     * @return mixed
     */
    public static function getProviderConfig( $provider, $code = null );

}