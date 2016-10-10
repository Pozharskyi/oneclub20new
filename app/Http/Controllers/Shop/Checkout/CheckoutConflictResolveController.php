<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.09.2016
 * Time: 14:52
 */

namespace App\Http\Controllers\Shop\Checkout;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Shop\Catalog\ShopCatalogSearchController;
use App\Models\Shop\Basket\BasketModel;
use Illuminate\Http\Request;

/**
 * Fixing conflicts with subproducts
 * If any reserved but basket is
 * not available or empty
 * Class CheckoutConflictResolveController
 * @package App\Http\Controllers\Shop\Checkout
 */
class CheckoutConflictResolveController extends Controller
{
    private $validation = true;

    /**
     * Fixing conflicts with products
     * In order to unreliable fixing products
     * @param Request $request
     * @param $user_id
     * @return string
     */
    public function actionResolveConflict( Request $request, $user_id )
    {
        $basket_items = $request->input('baskets_awp_ms');
        foreach( $basket_items as $basket_item )
        {
            $item = $this->actionGetSubProductIdDataByBasket( $basket_item );

            $reserved = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $item->sub_product_id );
            $available = $item->quantity - $reserved;

            $needle_for_user = $request->input( 'baskets_awp_qty_' . $basket_item );

            if( $needle_for_user > $available )
            {
                $this->validation = false;
            } else
            {
                $basket = BasketModel::find( $basket_item );
                $basket->sub_product_quantity = $needle_for_user;
                $basket->save();
            }
        }

        if( $this->validation === true )
        {
            return 'true';
        }

        return $user_id;
    }

    /**
     * Getting sub product
     * by product in basket
     * @param $basket_id
     * @return \stdClass
     */
    private function actionGetSubProductIdDataByBasket( $basket_id )
    {
        $data = BasketModel::with(['subProduct'])
            ->find( $basket_id );

        $result = new \stdClass;
        $result->sub_product_id = $data->sub_product_id;
        $result->quantity = $data->subProduct->quantity;

        return $result;
    }

}