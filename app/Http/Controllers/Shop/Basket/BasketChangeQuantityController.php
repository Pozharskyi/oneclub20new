<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.08.2016
 * Time: 16:09
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shop\Basket\BasketModel;

/**
 * Changing product quantity
 * Class BasketChangeQuantityController
 * @package app\Http\Controllers\Shop\Basket
 */
class BasketChangeQuantityController extends Controller
{
    /**
     * Getting data from Request
     * Increment or decrement based on $quantity
     * @param $basket_id
     * @param Request $request
     */
    public function actionChangeQuantity( $basket_id, Request $request ) {

        $item = BasketModel::FindOrFail( $basket_id );

        $quantity = $request->input('quantity');

        switch( $quantity ) {

            case '1':
                $item->sub_product_quantity++;
                break;

            case '-1':
                $item->sub_product_quantity--;
                break;

            default:
                die();

        }

        $item->save();
    }

}