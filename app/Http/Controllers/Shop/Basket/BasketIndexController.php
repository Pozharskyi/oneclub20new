<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 29.08.2016
 * Time: 22:33
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Shop\Basket\BasketModel;

/**
 * Getting basket view
 * Class BasketIndexController
 * @package app\Http\Controllers\Shop\Basket
 */
class BasketIndexController extends Controller
{
    /**
     * Collecting data for
     * Basket view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function actionIndex( Request $request )
    {
        if( Auth::guest() )
        {
            return redirect('/login');
        } else
        {
            $user_id = Auth::user()->id;

            $collection = BasketModel::where('user_id', $user_id)
                ->orderBy('id', 'DESC')
                ->with([
                    'subProduct.product',
                    'subProduct.color', 'subProduct.photos', 'subProduct.size',
                    'subProduct.product.description', 'subProduct.price',
                    'subProduct.product.brand',
                ])->get();

            $total = 0;
            $sale = 0;

            foreach( $collection as $item )
            {
                $total += $item->subProduct->price->special_price * $item->sub_product_quantity;
                $sale += ( $item->subProduct->price->final_price - $item->subProduct->price->special_price ) * $item->sub_product_quantity;
            }

            $error = $request->input('error');

            if( isset( $error ) )
            {
                $validation = new \stdClass;
                $validation->error = $error;
                $validation->available = $request->input('available');
                $validation->reserved = $request->input('reserved');
            } else
            {
                $validation = null;
            }

            return view('shop.basket.index', [
                'collection' => $collection,
                'total' => $total,
                'sale' => $sale,

                'count' => count( $collection ),

                'validation' => $validation,
                'user_id' => $user_id,
            ]);
        }
    }

}