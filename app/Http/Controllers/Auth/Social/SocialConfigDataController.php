<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.08.2016
 * Time: 9:26
 */

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Auth\Social\SocialConfigDataInterface;

/**
 * Getting Data @foreach Social Provider
 * @required params to @complete data with type @get code
 * Class SocialConfigDataController
 * @package App\Http\Controllers\Auth\Social
 */
class SocialConfigDataController extends Controller implements SocialConfigDataInterface
{
    /**
     * Based on @provider
     * Get config data
     * @param $provider
     * @param null $code
     * @return array
     */
    public static function getProviderConfig( $provider, $code = null ) {

        switch( $provider ) {

            /**
             * If Social Provider
             * @is facebook ...
             */
            case 'facebook':
                $params = array(
                    'client_id'     => '1643893395924319',
                    'client_secret' => '55eeea56b29ad62cec68db89eab14aef',
                    'redirect_uri'  => 'http://localhost:8081/social/facebook',
                    'code' => $code,
                    'response_type' => 'code',
                    'scope'         => 'email,public_profile,user_location,user_hometown',
                );
                break;

            /**
             * If Social Provider
             * @is google ...
             */
            case 'google':
                $params = array(
                    'client_id'     => '1086351434225-sbcfrbfi8t7kbe8kma9bvi9mse44a6m8.apps.googleusercontent.com',
                    'client_secret' => 'GExWI55OdJhM3aFb8YlpnPlR',
                    'redirect_uri'  => 'http://localhost:8081/social/google',
                    'grant_type'    => 'authorization_code',
                    'code'          => $code
                );
                break;

            /**
             * Else exit
             * No providers found.
             */
            default:
                $params = false;
        }

        return $params;
    }

}