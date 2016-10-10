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

use App\Http\Controllers\Shop\Basic\DiscountsController;
use App\Models\Discount\DiscountsModel;
use App\Models\Shop\Basket\BasketModel;

/**
 * Order prices
 * Validate if prices are real
 * Validate discount
 * Getting prices foreach product
 * Class OrderPricesController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderPricesController extends Controller
{
    /**
     * Getting prices and quantity for user's
     * basket
     * @param $user_id
     * @return \stdClass
     */
    public static function actionGetPricesAndQuantityFromBasket( $user_id )
    {
        $basket = BasketModel::where( 'user_id', $user_id )
            ->with(['subProduct.price' => function( $query ) use ( $user_id )
            {
                $query->get(['special_price']);
            }])
            ->get();

        $total_price = 0;
        $total_quantity = 0;

        foreach( $basket as $item )
        {
            $total_price += $item->subProduct->price->special_price * $item->sub_product_quantity;
            $total_quantity += $item->sub_product_quantity;
        }

        $prices = new \stdClass();

        $prices->total_price = $total_price;
        $prices->total_quantity = $total_quantity;

        return $prices;
    }

    /**
     * Calculating an discount for order
     * with price and amount of discount
     * @param $price
     * @param $discount
     * @return float
     */
    public static function actionCalculateDiscount( $price, $discount )
    {
        //add field moneyDiscount that contains discount value in money format
        DiscountsController::setMoneyDiscountField($discount, $price);

        return $price - $discount->moneyDiscount;
//        $discount_qty = 0;
//
//        foreach( $discounts as $discount )
//        {
//            $disc = DiscountsModel::findOrFail( $discount );
//
//            $discount_qty += $disc->discount_amount;
//        }
//
//        if( $discount_qty == 0 )
//        {
//            return $price;
//        } else
//        {
//            return ( ( 100 - $discount_qty ) * $price ) / 100;
//        }

    }

    /**
     * Getting total price
     * Getting total quantity
     * for Order
     * @param $user_id
     * @param $discounts
     * @param $bonuses
     * @return \stdClass
     */
    public static function actionGetPrices( $user_id, $discounts, $bonuses )
    {
        $basket = self::actionGetPricesAndQuantityFromBasket( $user_id );
        $real_price = self::actionCalculateDiscount( $basket->total_price, $discounts );
        $real_price -= $bonuses;

        $product = new \stdClass();

        $product->total_price = $real_price;
        $product->total_quantity = $basket->total_quantity;
        $product->original_sum = $basket->total_price;
        return $product;
    }

    public static function actionGetPricesWithBonus($user_id, $bonuses)
    {
        $basket = self::actionGetPricesAndQuantityFromBasket( $user_id );
        $real_price = $basket->total_price;
        $real_price -= $bonuses;

        $product = new \stdClass();
        $product->total_price = $real_price;
        $product->total_quantity = $basket->total_quantity;
        $product->original_sum = $basket->total_price;

        return $product;
    }

    public static function actionGetPricesWithDiscount($user_id, $discount)
    {
        $basket = self::actionGetPricesAndQuantityFromBasket( $user_id );
        $real_price = self::actionCalculateDiscount( $basket->total_price, $discount );

        $product = new \stdClass();
        $product->total_price = $real_price;
        $product->total_quantity = $basket->total_quantity;
        $product->original_sum = $basket->total_price;
        return $product;
    }

    public static function actionGetPricesWithNoDiscount($user_id)
    {
        $basket = self::actionGetPricesAndQuantityFromBasket( $user_id );
        $real_price = $basket->total_price;

        $product = new \stdClass();
        $product->total_price = $real_price;
        $product->total_quantity = $basket->total_quantity;
        $product->original_sum = $basket->total_price;

        return $product;
    }

}