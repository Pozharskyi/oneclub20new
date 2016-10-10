<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.08.2016
 * Time: 17:34
 */

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Controller;

/**
 * Getting links foreach
 * Social provider
 * Class SocialLinksAdapterController
 * @package App\Http\Controllers\Auth\Social
 */
class SocialLinksAdapterController extends Controller
{
    /**
     * @important to Change Localhost environment URLs
     * to prod in @production env
     *
     * Getting social config data
     * URL based on social param
     * @param $social
     * @return string
     */
    public static function getConfigForSocial( $social ) {

        switch( $social ) {

            /**
             * If provider
             * @is facebook ...
             */
            case 'facebook':
                $client_id = '1643893395924319'; // Client ID
                //$client_secret = '55eeea56b29ad62cec68db89eab14aef'; // Client secret
                $redirect_uri = 'http://localhost:8081/social/facebook'; // Redirect URIs

                $url = 'https://www.facebook.com/dialog/oauth';

                $params = array(
                    'client_id'     => $client_id,
                    'redirect_uri'  => $redirect_uri,
                    'response_type' => 'code',
                    'scope'         => 'email,public_profile,user_location,user_hometown'
                );

                $link = $url . '?' . urldecode(http_build_query($params));
                break;

            /**
             * If provider
             * @is google ...
             */
            case 'google':
                $client_id = '1086351434225-sbcfrbfi8t7kbe8kma9bvi9mse44a6m8.apps.googleusercontent.com'; // Client ID
                //$client_secret = 'GExWI55OdJhM3aFb8YlpnPlR'; // Client secret
                $redirect_uri = 'http://localhost:8081/social/google'; // Redirect URI

                $url = 'https://accounts.google.com/o/oauth2/auth';

                $params = array(
                    'redirect_uri'  => $redirect_uri,
                    'response_type' => 'code',
                    'client_id'     => $client_id,
                    'scope'         => 'profile email https://www.googleapis.com/auth/plus.login'
                );

                $link = $url . '?' . urldecode(http_build_query($params));
                break;

            /**
             * Else exit
             * No Adapters found.
             */
            default:
                $link = false;
        }

        /**
         * @return Auth link
         * @foreach Social Provider
         */
        return $link;
    }

}