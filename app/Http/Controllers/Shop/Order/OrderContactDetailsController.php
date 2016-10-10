<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 01.09.2016
 * Time: 12:46
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderContactDetailsModel;

/**
 * Order contact details
 * Class OrderContactDetailsController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderContactDetailsController extends Controller
{
    /**
     * Inserting order contact details
     * @with Transaction
     * @param $order_id
     * @param $request
     */
    public static function actionSaveContactDetails( $order_id, $request )
    {
        $details = new OrderContactDetailsModel();

        $details->order_id = $order_id;
        $details->f_name = $request->input('f_name');
        $details->l_name = $request->input('l_name');
        $details->city = $request->input('city');
        $details->cell = $request->input('cell');
        $details->email = $request->input('email');

        $details->save();
    }

}