<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 31.08.2016
 * Time: 14:49
 */

namespace App\Http\Controllers\Shop\Basic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Models\Basic\BasicDiscountsModel;
use App\Models\Discount\DiscountsModel;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\String_;
use Redis;
use Session;

/**
 * Main class for users discounts
 * Getting status for discount
 * Validating for availability
 * Class DiscountsController
 * @package App\Http\Controllers\Shop\Basic
 */
class DiscountsController extends Controller
{
    /**
     * Current Timestamp in UNIX format
     * @var int
     */
    private $now;

    /**
     * Coupon status
     * If error
     * @return string
     * else
     * @return int
     */
    private $status;

    /**
     * prices Object from OrderPricesController::actionGetPricesAndQuantityFromBasket
     * contains totalQuantity and totalPrice fields
     */
    private $prices;


    /**
     * Getting current timestamp in UNIX format
     * DiscountsController constructor.
     */
    public function __construct()
    {
        // now
        $this->now = strtotime('now');
    }

    public function actionGetAutoDiscount(Request $request)
    {
        $user = Auth::user();

        $discounts = DiscountsModel::whereAuto()
            ->filterByData(Carbon::now())
            ->filterByStatus()
            ->filterByCategoriesOrUser($user);

        $prices = OrderPricesController::actionGetPricesAndQuantityFromBasket($user->id);
        $totalPrice = $prices->total_price;
        $totalQuantity = $prices->total_quantity;
        $purchaseNumber = $user->orders()->count();

        $discounts = $discounts
            ->filterByBasketSum($totalPrice)
            ->filterBySubproductAmount($totalQuantity)
            ->filterByPurchaseNumber($purchaseNumber);

        //check valid discount by paymentType and deliveryType
        $paymentTypeId = $request->payment_type;
        $deliveryTypeId = $request->delivery_type;
//        $discounts = $discounts->filterByPaymentType($paymentTypeId)
//                                ->filterByDeliveryType($deliveryTypeId);

        $newDiscounts = Collection::make();
        foreach ($discounts->get() as $discount) {
            $d1 = clone $discount;
            $d2 = clone $discount;

            $countOfUsedByUser = $d1->getCountOfUsedByUser($user)->get()->count();
            $countOfUsedByAll = $d2->getCountOfUsedByAll()->get()->count();


            $discount = DiscountsModel::where('id', $discount->id)
                ->filterByCouponRule($countOfUsedByAll, $countOfUsedByUser)
                ->first();
            if ($discount) {
                $newDiscounts->add($discount);
            }
        }
        //set new field for discount value in money
        foreach ($newDiscounts as $newDiscount) {
            self::setMoneyDiscountField($newDiscount, $totalPrice);
        }
        //get autoDiscount with max money
        $autoDiscount = $newDiscounts->sortBy('moneyDiscount')->first();

        if ($autoDiscount) {
            Session::put('autoDiscountId', $autoDiscount->id);
        }
        if(!$autoDiscount){
            return "нет доступных автоматических скидок";
        }
        return $autoDiscount;
    }

    /**
     * @param Request $request
     * @return string || DiscountModel object
     * if order parameters not valid for discount, return status
     * else return discount
     */
    public function getDiscountAmountByCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        $discount = DiscountsModel::whereCouponCode($couponCode)
            ->whereNotAuto()
        ->filterByCategoriesOrUser(Auth::user());

        /**
         * If not exists in table
         */
        if (!$discount->first()) {
            $this->status = 'Скидка не доступна';
            return $this->status;
        }
        /**
         * Validate for no errors
         * in discount
         */

        $availability = $this->actionCheckIfDiscountAvailable($discount);

        /**
         * If no errors ...
         */
        if ($availability) {

            $totalPrice = $this->prices->total_price;
            $discount = $discount->first();
            self::setMoneyDiscountField($discount, $totalPrice);

            Session::put('discountId', $discount->id);

            // getting discount
            return $discount;
        }


        // else return error status
        return $this->status;

    }

    /**
     * Index method for validation of discount
     * @param $discount
     * @return bool
     */
    private function actionCheckIfDiscountAvailable($discount)
    {
        // if coupon dates expired
        if ($discount->filterByData(Carbon::now())->get()->isEmpty() === true) {

            $this->status = 'Время действия акции закончилось';
            return false;
        }

        // if coupon status 0
        if ($discount->filterByStatus()->get()->isEmpty()) {

            $this->status = 'Статус акции - закрыта';
            return false;
        }
        $user = Auth::user();
        $d1 = clone $discount;
        $d2 = clone $discount;

        $countOfUsedByUser = $d1->getCountOfUsedByUser($user)->count();
        $countOfUsedByAll = $d2->getCountOfUsedByAll()->count();


        // if coupon_rules invalid
        if ($discount->filterByCouponRule($countOfUsedByAll, $countOfUsedByUser)->get()->isEmpty() === true) {

            $this->status = 'Купон больше не доступен'. $countOfUsedByUser. '  '. $countOfUsedByAll;
            return false;
        }

        //set prices Object from basket
        $this->prices = OrderPricesController::actionGetPricesAndQuantityFromBasket($user->id);
        $totalPrice = $this->prices->total_price;
        $totalQuantity = $this->prices->total_quantity;

        // if basket totalSum not in discount's price range
        if ($discount->filterByBasketSum($totalPrice)->get()->isEmpty()) {

            $this->status = 'Сумма заказа не подходит для данного купона';
            return false;
        }

        // if basket subProduct quantity ($totalQuantity) not equal discount subProductQuantity
        if ($discount->filterBySubproductAmount($totalQuantity)->get()->isEmpty()) {

            $this->status = 'Количество товаров не подходит для данного купона';
            return false;
        }

        $purchaseNumber = $user->orders()->count();
        //if user's order number (amount of user's purchases) not valid for this discount
        if ($discount->filterByPurchaseNumber($purchaseNumber)->get()->isEmpty()) {

            $this->status = 'Номер покупки не подходит для данного купона';
            return false;
        }
        return true;
    }

    public static function setMoneyDiscountField($discount, $totalPrice)
    {
        if ($discount->type == "percent") {
            $discount['moneyDiscount'] = ($discount->discount_amount * $totalPrice / 100);
        } else {
            $discount['moneyDiscount'] = $discount->discount_amount;
        }
    }

}