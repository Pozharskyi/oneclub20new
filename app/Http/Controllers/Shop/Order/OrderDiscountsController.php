<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 31.08.2016
 * Time: 16:52
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;

use App\Models\Discount\DiscountsModel;
use App\Models\Order\OrderDiscountModel;
use App\Models\Order\OrderModel;
use Illuminate\Http\Request;
use Session;

/**
 * Order discounts
 * Validation of discounts
 * Inserting discounts into order
 * Updating discounts in order to make inactive
 * Class OrderDiscountsController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderDiscountsController extends Controller
{

    /**
     * Validate if discounts exists
     * @param $discountId
     * @param $deliveryTypeId
     * @param $paymentTypeId
     * @return array|bool
     */
    public static function actionFindDiscounts($discountId, $deliveryTypeId, $paymentTypeId)
    {
        //TODO uncomment after test
//        if ($discountId) {
//            $discount = DiscountsModel::where('id', $discountId)
//                ->filterByPaymentType($paymentTypeId)
//                ->filterByDeliveryType($deliveryTypeId)
//                ->first();
//        }
        $discount = DiscountsModel::where('id', $discountId)->first();

//        if(!isset($discount) || !$discount ){
//            $autoDiscountId = Session::get('autoDiscountId');
//            $autoDiscount = DiscountsModel::where('id', $autoDiscountId)
//                ->filterByPaymentType($paymentTypeId)
//                ->FilterByDeliveryType($deliveryTypeId)
//                ->first();
//            if($autoDiscount){
//                return $autoDiscount;
//            } else {
//                return false;
//            }
//        }
        if (!isset($discount) || !$discount) {
            return false;
        }
        return $discount;
    }

    /**
     * Make discounts not active
     * @param $discount
     */
    public static function actionUpdateDiscounts($discount)
    {
        $discount->status = "Не активный";
        $discount->save();
    }

    /**
     * Inserting for order
     * used discounts
     * @param $order_id
     * @param $discount
     */
    public static function actionInsertDiscounts($order_id, $discount)
    {
        $order = OrderModel::findOrFail($order_id);
        $order->discount()->associate($discount);
        $order->save();
    }

}