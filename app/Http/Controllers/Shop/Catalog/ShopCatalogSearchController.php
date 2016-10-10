<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.09.2016
 * Time: 15:30
 */

namespace App\Http\Controllers\Shop\Catalog;

use App\Http\Controllers\Controller;

use App\Models\Product\SubProductModel;
use App\Models\Shop\Basket\BasketModel;

define('MAX_TIME_FOR_RESERVE', 1200); // 20 minutes

/**
 * Search if items in catalog
 * might be reserved or free
 * Class ShopCatalogSearchController
 * @package App\Http\Controllers\Shop\Catalog
 */
class ShopCatalogSearchController extends Controller
{
    /**
     * Getting sizes for products
     * By product
     * By color
     * @param $product_id
     * @param $color_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetSizesForProductByColor( $product_id, $color_id )
    {
        $data = SubProductModel::where( 'dev_product_index_id', $product_id )
            ->where( 'dev_product_color_id', $color_id )
            ->with(['size'])
            ->get();

        return view('shop.catalog.search.sizes', [
            'data' => $data,
        ]);
    }

    /**
     * Getting reserved quantity for sub product
     * For user or not for current user
     * @param $sub_product_id
     * @param null $user_id
     * @param null $selector
     * @return mixed
     */
    public static function actionFindReservedQuantityForSubProduct( $sub_product_id, $user_id = null, $selector = null )
    {
        $reserve_time_timestamp = strtotime('now') - MAX_TIME_FOR_RESERVE;
        $reserve_time = date( 'Y-m-d H:i:s', $reserve_time_timestamp );

        $reserved = BasketModel::where( 'sub_product_id', $sub_product_id )
            ->where( 'updated_at', '>=', $reserve_time)
            ->user( $user_id, $selector )
            ->sum('sub_product_quantity');

        return $reserved;
    }

    /**
     * Getting available quantity for product
     * By color with
     * By size
     * @param $product_id
     * @param $color_id
     * @param $size_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetQuantityForProduct( $product_id, $color_id, $size_id )
    {
        $all = SubProductModel::where( 'dev_product_index_id', $product_id )
            ->where( 'dev_product_color_id', $color_id )
            ->sum('quantity');

        $reserved = $this->actionGetReservedQuantityForProduct( $product_id, $color_id, $size_id );
        $available = $all - $reserved + 1; // not from zero

        return view('shop.catalog.search.quantity',
            [
                'available' => $available
            ]
        );
    }

    /**
     * Finding sub product
     * By color and size
     * with product id
     * @param $product_id
     * @param $color_id
     * @param $size_id
     * @return mixed
     */
    private function actionFindSubProduct( $product_id, $color_id, $size_id )
    {
        $data = SubProductModel::where( 'dev_product_index_id', $product_id )
            ->where( 'dev_product_color_id', $color_id )
            ->where( 'dev_product_size_id', $size_id )
            ->first(['id']);

        return $data->id;
    }

    /**
     * Getting reserved quantity for product
     * By color and size
     * @param $product_id
     * @param $color_id
     * @param $size_id
     * @return mixed
     */
    private function actionGetReservedQuantityForProduct( $product_id, $color_id, $size_id )
    {
        $sub_product = $this->actionFindSubProduct( $product_id, $color_id, $size_id );

        $reserve_time_timestamp = strtotime('now') - MAX_TIME_FOR_RESERVE;
        $reserve_time = date( 'Y-m-d H:i:s', $reserve_time_timestamp );

        $reserved = BasketModel::where( 'sub_product_id', $sub_product )
            ->where( 'updated_at', '>=', $reserve_time)
            ->sum('sub_product_quantity');

        return $reserved;
    }

}