<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.09.2016
 * Time: 14:24
 */

namespace app\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductModel;
use Session;

class AdminProductsDeleteController extends Controller
{
    public function actionDeleteProduct( $product_id )
    {
        $product = ProductModel::findOrFail($product_id);
        $product->delete();

        Session::flash('message', 'Продукт был успешно удален');
        return redirect()->back();
    }

}