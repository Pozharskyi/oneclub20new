<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.09.2016
 * Time: 17:28
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Catalog\ShopCatalogSearchController;

use App\Models\Product\SubProductModel;
use App\Models\Shop\Basket\BasketModel;
use Illuminate\Http\Request;

/**
 * Reserving items back to basket
 * if available
 * Class BasketReserveBackController
 * @package App\Http\Controllers\Shop\Basket
 */
class BasketReserveBackController extends Controller
{
    /**
     * Getting items reserve back
     * for basket if time is out for 20:00
     * @param Request $request
     * @param $basket_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionReserveBack( Request $request, $basket_id )
    {
        $quantity = $request->input('quantity');
        $sub_product = $this->actionFindSubProductIdByBasket( $basket_id );

        $sub = SubProductModel::find( $sub_product->sub_product_id );

        $reserved = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $sub_product->sub_product_id );

        $available = $sub->quantity - $reserved;
        $difference = $available - $quantity;

        $result = array();

        $basket = BasketModel::find( $basket_id );

        if( $difference > 0 )
        {
            $basket->sub_product_quantity = $quantity;
            $basket->updated_at = date('Y-m-d H:i:s', strtotime('now'));
            $basket->save();

            $result['items'] = $quantity;
            $result['message'] = 'Данный продукт был успешно зарезервирован. Количество: ' . $quantity;

        } elseif( $difference == 0 )
        {
            $basket->delete();

            $result['items'] = 0;
            $result['message'] = 'Данный продукт был зарезервирован или выкуплен. Доступно: ' . $difference;
        } else
        {
            $basket->sub_product_quantity = $available;
            $basket->save();

            $result['items'] = $available;
            $result['message'] = 'Данных продуктов доступно только: ' . $available . ', зарезервировано: ' . $reserved;
        }

        return response()->json( $result );

    }

    /**
     * Getting sub product id
     * by basket id
     * @param $basket_id
     * @return mixed
     */
    private function actionFindSubProductIdByBasket( $basket_id )
    {
        $item = BasketModel::find( $basket_id );

        return $item;
    }

}