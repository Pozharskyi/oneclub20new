<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.08.2016
 * Time: 13:13
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;

use App\Models\Shop\Basket\BasketModel;

/**
 * Deleting an product
 * Class BasketDeleteDataController
 * @package app\Http\Controllers\Shop\Basket
 */
class BasketDeleteDataController extends Controller
{
    /**
     * Deleting an item
     * from Basket
     * @param $id
     */
    public function actionDeleteFromBasket( $id )
    {
        $item = BasketModel::FindOrFail( $id );
        $item->delete();
    }

}