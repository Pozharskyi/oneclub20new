<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 31.08.2016
 * Time: 16:31
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Shop\Basic\BalancesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop\Basket\BasketModel;
use App\Models\Order\OrderModel;
use DB;
use Session;

/**
 * Creating an order
 * with Transaction
 * Class OrderController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderController extends Controller
{
    /**
     * Auth user id
     * @var
     */
    private $user_id;
    private $isBalanceUsed;
    /**
     * Saving an order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function actionSaveOrder(Request $request)
    {
        // getting user id
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $this->user_id = Auth::user()->id;
        }

        // discounts used
//        $discounts = explode(",", $request->input('discounts') );
//        $couponCode = $request->input('discount');
        $paymentTypeId = $request->payment_type;
        $deliveryTypeId = $request->delivery_type;


        // validate if products available
        $productsValidation = OrderProductsController::actionValidateProductsAvailability($this->user_id);

        //check if user used his balance
        $this->isBalanceUsed = $request->useBalance == "on" ? true : false;
//        if( $bonusesValidation === false ) {
//            // if bonuses not exists
//            return 'You have not enough bonuses';
//        } elseif( $discountsValidation === false )
//        {
//            // if discounts not exists
//            return 'Incorrect discounts!';
//        }

        //TODO action if products reserved
//        if( $productsValidation === false )
//        {
//            // if products reserved
//            return 'Products are already reserved';
//        }

        // getting all products from basket
        $basket_products = OrderProductsController::actionGetBasketProducts($this->user_id);

        // generate public order id
        $public_order_id = $this->actionGetPublicOrderId($request->input('cell'));

        // begin Transaction
        DB::beginTransaction();

        try {
            if ($request->discount_bonus === "discount" || $request->discount_bonus === "auto_discount") {
                if ($request->discount_bonus === "discount") {
                    $discountId = Session::get('discountId');
                } else {
                    $discountId = Session::get('autoDiscountId');
                }
                $discountValidation = OrderDiscountsController::actionFindDiscounts($discountId, $deliveryTypeId, $paymentTypeId);
                if ($discountValidation) {
                    //update discounts and ...
                    //TODO uncomment if we change status to Не Активный
//                        OrderDiscountsController::actionUpdateDiscounts( $discountValidation );
                    // updating users data
                    OrderProductsController::actionUpdateProductsQuantity($basket_products);
                    // Getting price with discounts
                    $total = OrderPricesController::actionGetPricesWithDiscount($this->user_id, $discountValidation);

                    //balance logic for update total_sub before saving order
                    if($this->isBalanceUsed){
                        $total = OrderBalanceController::changeTotalPriceUpdateBalanceUser($total);
                    }

                    $order_id = $this->actionInsertOrder($public_order_id, $request, $total);

                    /** insert into orders */
                    if($this->isBalanceUsed){
                        OrderBalanceController::actionInsertBalance($order_id);
                    }

                    OrderDiscountsController::actionInsertDiscounts($order_id, $discountValidation);

                    OrderProductsController::actionInsertProducts($order_id, $productsValidation);

                    // add to order items
                    OrderContactDetailsController::actionSaveContactDetails($order_id, $request);
                    OrderDeliveryController::actionSaveOrderDelivery($order_id, $request);
                } else {

                    $this->actionOrderConfirmWithNoDiscount($request, $basket_products, $public_order_id, $productsValidation);
                }
                Session::forget('autoDiscountId');
                Session::forget('discountId');

            } elseif ($request->discount_bonus === "bonus") {
                //bonus logic
                // bonuses used
                $bonuses = $request->input('bonuses_used');

                // validate if bonuses exists
                $bonusesValidation = OrderBonusesController::actionValidateUserBonuses($this->user_id, $bonuses);
                if ($bonusesValidation) {
                    //update bonuses ...
                    OrderBonusesController::actionUpdateBonuses($bonusesValidation, $bonuses);
                    // updating users data
                    OrderProductsController::actionUpdateProductsQuantity($basket_products);
                    // Getting price with bonus
                    $total = OrderPricesController::actionGetPricesWithBonus($this->user_id, $bonuses);

                    //balance logic for update total_sub before saving order
                    if($this->isBalanceUsed){
                        $total = OrderBalanceController::changeTotalPriceUpdateBalanceUser($total);
                    }

                    $order_id = $this->actionInsertOrder($public_order_id, $request, $total);

                    /** insert into orders */
                    if($this->isBalanceUsed){
                        OrderBalanceController::actionInsertBalance($order_id);
                    }

                    OrderBonusesController::actionInsertBonuses($order_id, $bonuses);
                    OrderProductsController::actionInsertProducts($order_id, $productsValidation);
                    // add to order items
                    OrderContactDetailsController::actionSaveContactDetails($order_id, $request);
                    OrderDeliveryController::actionSaveOrderDelivery($order_id, $request);
                } else {

                    $this->actionOrderConfirmWithNoDiscount($request, $basket_products, $public_order_id, $productsValidation);
                }

            } else {        //if no discounts or bonus selected
                $this->actionOrderConfirmWithNoDiscount($request, $basket_products, $public_order_id, $productsValidation);

            }
            // updating users data
//                OrderProductsController::actionUpdateProductsQuantity( $basket_products );

            // Getting price
//                $total = OrderPricesController::actionGetPrices( $this->user_id, $discountsValidation, $bonuses );
//                $order_id = $this->actionInsertOrder( $public_order_id, $request, $total );

            /** insert into orders */
//                OrderDiscountsController::actionInsertDiscounts( $order_id, $discountsValidation );
//                OrderProductsController::actionInsertProducts( $order_id, $productsValidation );

            // add to order items
//                OrderContactDetailsController::actionSaveContactDetails( $order_id, $request );
//                OrderDeliveryController::actionSaveOrderDelivery( $order_id, $request );

            // clear user basket
            BasketModel::where('user_id', $this->user_id)
                ->delete();

            // if succeed do
            DB::commit();
        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();
            return 'Bad request';
        }

//         must be thank you page
//        return "Заказ успешно оформлен";
        Session::flash('message', 'Заказ успешно оформлен');
        return redirect('/');
    }

    /**
     * Getting public order id
     * @param $phone
     * @return string
     */
    public function actionGetPublicOrderId($phone)
    {
        $order = new OrderEncryptionController;

        $public_order_id = $order->actionGetData($phone);

        return $public_order_id;
    }

    /**
     * Create order Object
     * @param $public_order_id
     * @param Request $request
     * @param $total
     * @return mixed
     */
    public function actionInsertOrder($public_order_id, Request $request, $total)
    {
        $order = new OrderModel();

        $order->user_id = $this->user_id;
        $order->public_order_id = $public_order_id;
        $order->comment = $request->input('comment');
        $order->total_sum = $total->total_price;
        $order->original_sum = $total->original_sum;
        $order->total_quantity = $total->total_quantity;
        $order->payment_type_id = $request->input('payment_type');

        $order->save();

        return $order->id;
    }

    /**
     * @param Request $request
     * @param $basket_products
     * @param $public_order_id
     * @param $productsValidation
     * confirm order if discount and bonus did not chosen
     */
    private function actionOrderConfirmWithNoDiscount(Request $request, $basket_products, $public_order_id, $productsValidation)
    {
        OrderProductsController::actionUpdateProductsQuantity($basket_products);
        $total = OrderPricesController::actionGetPricesWithNoDiscount($this->user_id);
        //balance logic for update total_sub before saving order
        if($this->isBalanceUsed){
            $total = OrderBalanceController::changeTotalPriceUpdateBalanceUser($total);
        }

        $order_id = $this->actionInsertOrder($public_order_id, $request, $total);

        if($this->isBalanceUsed){
            OrderBalanceController::actionInsertBalance($order_id);
        }

        OrderProductsController::actionInsertProducts($order_id, $productsValidation);

        OrderContactDetailsController::actionSaveContactDetails($order_id, $request);
        OrderDeliveryController::actionSaveOrderDelivery($order_id, $request);
    }

}