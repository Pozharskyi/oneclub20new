<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.08.2016
 * Time: 14:38
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop\Basket\BasketModel;

// MAX TIME FOR RESERVING AN ITEM
define('MAX_TIME_FOR_RESERVE', '1200'); // in seconds 20 minutes

/**
 * Basket index timer
 * Getting timers for each products
 * Class BasketTimerController
 * @package app\Http\Controllers\Shop\Basket
 */
class BasketTimerController extends Controller
{
    /**
     * Getting all reserve timestamps
     * from current timestamp
     * with id
     * @return string
     */
    public function actionIndex()
    {
        if( Auth::guest() )
        {
            return redirect('/login');
        } else
        {
            $basket = BasketModel::where('user_id', '=', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->get(['id', 'updated_at']);

            $result = array();
            $now = strtotime('now');

            foreach( $basket as $item ) {

                $updated_timestamp = strtotime( $item->updated_at );
                $updated_end = $updated_timestamp + MAX_TIME_FOR_RESERVE;

                $difference = $updated_end - $now;

                if( $difference < 0 ) {
                    $difference = 0;
                }

                $result[$item->id] = $difference;
            }

            $json = json_encode( $result );

            return $json;
        }
    }

}