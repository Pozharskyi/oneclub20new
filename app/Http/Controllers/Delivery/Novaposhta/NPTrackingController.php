<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 17.08.2016
 * Time: 15:06
 */

namespace App\Http\Controllers\Delivery\Novaposhta;

use App\Http\Controllers\Controller;

class NPTrackingController extends Controller
{
    public static function actionGetTrackingData( $order_id ) {

        $np = NPConfigController::getInstance();

        $result = $np->documentsTracking( $order_id );

        if( $result['data'][0]['StateName'] == 'Номер не знайдено' )
        {
            return '<h1>Not Found</h1>';
        } else
        {
            return '<h1>Found</h1>';
        }
    }

}