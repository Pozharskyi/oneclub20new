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

use App\Models\Shop\Basket\BasketModel;
use App\Models\Product\SubProductModel;
use App\Models\Product\ProductIndexPricesModel;
use App\Models\Order\OrderIndexSubProductModel;

/**
 * Getting all user's basket products
 * Validate if products are available
 * Updating products quantity
 * Inserting products into order
 * Getting prices foreach product
 * Class OrderProductsController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderProductsController extends Controller
{
    /**
     * Getting all products from basket
     * @param $user_id
     * @return bool
     */
    public static function actionGetBasketProducts( $user_id )
    {
        $products = BasketModel::where('user_id', '=', $user_id)
            ->get(['sub_product_id', 'sub_product_quantity']);
//        var_dump($products->toArray());
        // if no products
//        var_dump( count( $products ));
        if( count( $products ) == 0 )
        {
            return false;
        } else
        {
            return $products;
        }
    }

    /**
     * Validating if products are available
     * @param $user_id
     * @return array|bool
     */
    public static function actionValidateProductsAvailability( $user_id )
    {
        /**
         * Getting products from basket
         */
        $products = self::actionGetBasketProducts( $user_id );

        $sub_products = array();
//        if(!$products){
//            return false;
//        }
        // validation of each product
        foreach( $products as $product )
        {
            $basic = SubProductModel::where('id', '=', $product->sub_product_id)
                ->where('quantity', '>=', $product->sub_product_quantity)
                ->get(['id']);

            if( count( $basic ) == 0 )
            {
                return false;
            } else
            {
                /*array_push( $sub_products, $product->sub_product_id );*/

                $sub_products[] = [
                    'sub_product_id'=>$product->sub_product_id,
                    'quantity'=>$product->sub_product_quantity];
            }
        }
        // return array | false
        return $sub_products;
    }

    /**
     * Update sub products quantity
     * if order complete
     * @param $products
     */
    public static function actionUpdateProductsQuantity( $products )
    {
        foreach( $products as $product )
        {
            $data = SubProductModel::findOrFail( $product->sub_product_id );

            $data->quantity -= $product->sub_product_quantity;

            $data->save();
        }

    }

    /**
     * Inserting products for order
     * with basic prices
     * @param $order_id
     * @param $products
     */
    public static function actionInsertProducts( $order_id, $products )
    {
        $prices = self::actionGetPricesForProducts( $products );
        $i = 0;
        foreach( $products as $product )
        {
            OrderIndexSubProductModel::create([
                'dev_sub_product_id' => $product['sub_product_id'],
                'dev_order_index_id' => $order_id,
                'price_for_one_product' => $prices[$i],
                'qty'   => $product['quantity'],
            ]);

            $i++;
        }
    }

    /**
     * Getting all prices for products
     * @param $products
     * @return array
     */
    public static function actionGetPricesForProducts( $products )
    {
        $prices_array = array();
        foreach( $products as $product )
        {
            $parent_id = self::actionFindParentIdBySubProduct( $product['sub_product_id'] );

            $index_price = ProductIndexPricesModel::findOrFail( $parent_id );

            array_push( $prices_array, $index_price->special_price );
        }

        return $prices_array;

    }

    /**
     * Getting parent product
     * based on sub product
     * @param $product
     * @return mixed
     */
    public static function actionFindParentIdBySubProduct( $product )
    {

        $parent_id = SubProductModel::FindOrFail( $product );

        return $parent_id->dev_product_index_id;
    }
}