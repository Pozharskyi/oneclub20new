<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 17:49
 */

namespace App\Http\Controllers\Shop\Catalog;

use App\Http\Controllers\Controller;

use App\Models\Product\SubProductModel;
use App\Models\Product\ProductModel;

class ShopCatalogReserveController extends Controller
{
    /**
     * Getting reserve status for catalog
     * Case: out of stock
     * Case: in stock
     * Case: in reserve
     * @param $products
     * @return array
     */
    public static function actionCheckProductAvailability( $products )
    {
        $products_availability = array();

        $now = date('Y-m-d H:i:s', strtotime('now -20 minutes'));

        foreach( $products as $product )
        {
            $quantity = SubProductModel::where( 'dev_product_index_id', $product->id )
                ->sum('quantity');

            $products_availability[$product->id] = array();
            $products_availability[$product->id]['total_quantity'] = $quantity;

            $reserve = ProductModel::find( $product->id )
                ->with(['subProducts', 'subProducts.basket'  => function( $query ) use ( $now ) {
                    $query->where('dev_index_basket.updated_at', '>=', $now)
                        ->sum('sub_product_quantity');
                }])
                ->first();

            if( !isset( $reserve->subProducts[0]->basket[0] ) )
            {
                $in_reserve = 0;
            } else
            {
                $in_reserve = $reserve->subProducts[0]->basket[0]->sub_product_quantity;
            }

            $products_availability[$product->id]['reserved'] = $in_reserve;
            $products_availability[$product->id]['delta'] = $quantity - $in_reserve;

            if( $quantity == 0 )
            {
                $stock = 'Out of stock';
            } elseif( $quantity - $in_reserve == 0 )
            {
                $stock = 'In reserve';
            } else
            {
                $stock = 'In stock';
            }

            $products_availability[$product->id]['stock'] = $stock;
        }

        return $products_availability;
    }

}