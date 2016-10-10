<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.09.2016
 * Time: 14:13
 */

namespace App\Http\Controllers\Shop\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Catalog\ShopCatalogSearchController;

use App\Models\Product\SubProductModel;
use App\Models\Shop\Basket\BasketModel;

/**
 * Validating products for checkout
 * And return view popup if any errors
 * Else get checkout page
 * @!important redirect
 * Class CheckoutProductValidationController
 * @package App\Http\Controllers\Shop\Checkout
 */
class CheckoutProductValidationController extends Controller
{
    /**
     * Getting errors
     * @var array
     */
    private $validation_error = array();

    /**
     * Getting data about
     * items
     * @var array
     */
    private $validation_items = array();

    /**
     * Checking if products are available
     * Getting reserved quantity for products
     * if errors push to $this
     * and return View
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function actionCheckProductsForCheckout( $user_id )
    {
        $basket = BasketModel::where( 'user_id', $user_id )
            ->get(['sub_product_id', 'sub_product_quantity']);

        foreach( $basket as $item )
        {
            $this->actionGetReservedQuantityForProductByUser( $item->sub_product_id, $item->sub_product_quantity, $user_id );
        }

        if( !empty( $this->validation_error ) )
        {
            foreach( $this->validation_error as $error )
            {
                array_push( $this->validation_items, $error['basket_id'] );
            }

            $data = BasketModel::with([
                'subProduct.size', 'subProduct.color', 'subProduct.photos',
                'subProduct.product.price', 'subProduct.product.description',
            ])->find( $this->validation_items );

            $i = 0;
            $count = count( $data );

            while( $i < $count )
            {
                $data[$i]->total = $this->validation_error[$i]['total'];
                $data[$i]->reserved = is_null( $this->validation_error[$i]['reserved'] ) ?
                    0 : $this->validation_error[$i]['reserved'];
                $data[$i]->needle = $this->validation_error[$i]['needle'];
                $data[$i]->available = $this->validation_error[$i]['available'];

                $i++;
            }

            return view('shop.checkout.checkout_conflict',
                [
                    'conflicts' => $data,
                    'count' => $count,
                ]
            );
        }

        return 'true';
    }

    /**
     * Getting reserved quantity for product
     * By users
     * @param $sub_product_id
     * @param $needle
     * @param $user_id
     */
    public function actionGetReservedQuantityForProductByUser( $sub_product_id, $needle, $user_id )
    {
        $reserved = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $sub_product_id, $user_id );
        $reserved_by_users = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $sub_product_id, $user_id, 'users'  );

        $total = SubProductModel::where( 'id', $sub_product_id )
            ->first(['quantity']);

        $basket_id = BasketModel::where( 'user_id', $user_id )
            ->where( 'sub_product_id', $sub_product_id )
            ->first(['id']);

        $available = $total->quantity - $reserved - $reserved_by_users;
        $totalToGet = $needle - $reserved;

        $basket = BasketModel::find( $basket_id->id );

        if( $totalToGet != 0 )
        {
            if( $totalToGet > $available )
            {
                $this->validation_error[] = array(
                    'basket_id' => $basket_id->id,
                    'sub_product_id' => $sub_product_id,

                    'total' => $total->quantity,
                    'reserved' => $reserved_by_users,
                    'needle' => $needle,
                    'available' => $available,
                );
            } else
            {
                $basket->sub_product_quantity = $totalToGet;
                $basket->save();
            }
        }

    }
}