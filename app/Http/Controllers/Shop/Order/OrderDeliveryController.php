<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 01.09.2016
 * Time: 12:47
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderDeliveryModel;

/**
 * Order delivery details
 * Inserting delivery details for order
 * Class OrderDeliveryController
 * @package app\Http\Controllers\Shop\Order
 */
class OrderDeliveryController extends Controller
{
    /**
     * Inserting into order
     * Delivery details
     * @param $order_id
     * @param $request
     */
    public static function actionSaveOrderDelivery( $order_id, $request )
    {
        $delivery = new OrderDeliveryModel;

        $delivery->order_id = $order_id;
        $delivery->delivery_type_id = $request->input('delivery_type');
        $delivery->delivery_f_name = $request->input('delivery_f_name');
        $delivery->delivery_l_name = $request->input('delivery_l_name');
        $delivery->delivery_phone = $request->input('delivery_cell');
        $delivery->delivery_address = $request->input('delivery_address');

        $delivery->save();

    }

}