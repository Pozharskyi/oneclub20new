<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 17.08.2016
 * Time: 12:36
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Social\SocialLinksAdapterController;

class AuthorizationController extends Controller
{
    public function index()
    {
        /**
         * Array to commit
         * for Login @view
         */
        $data = array();

        /**
         * Array of social providers
         * needed to commit
         */
        $socials = array(
            'facebook',
            'google',
        );

        /**
         * Iterate foreach social
         * provider service
         */
        foreach( $socials as $social )
        {
            /**
             * Generate photo
             * @url foreach provider
             */
            $photo_url = '/images/' . $social . '_logo.png';

            /**
             * Getting config URL
             * foreach photo
             */
            $data[$photo_url] = SocialLinksAdapterController::getConfigForSocial( $social );
        }

        /**
         * Return Login View
         */
        return view( 'auth/login', [ 'social' => $data ] );
    }

}