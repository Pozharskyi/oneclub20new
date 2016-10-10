<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.09.2016
 * Time: 14:25
 */

namespace app\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductModel;

class AdminProductsReadController extends Controller
{
    public function actionReadProduct()
    {
        $products = ProductModel::paginate(2);

        return view('admin.panel.products.index', compact('products'));
    }

}