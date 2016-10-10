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
use App\Models\Basic\BasicGenderModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductBrandsModel;
use App\Models\Product\ProductGenderModel;
use App\Models\Product\ProductModel;
use App\Models\Product\ProductStockModel;
use Illuminate\Http\Request;
use Session;

class AdminProductsUpdateController extends Controller
{
    public function actionGetUpdateProductForm(Request $request, $productId)
    {
        $product = ProductModel::with(['description', 'category', 'brand', 'gender', 'stock'])->findOrFail($productId);

        $genders = BasicGenderModel::orderBy('id')->get();

        $brands = ProductBrandsModel::orderBy('id')->get();
        $stocks = ProductStockModel::orderBy('id')->get();
        $categories = CategoryModel::orderBy('id')->get();

        return view('admin.panel.products.edit', compact('product', 'genders', 'brands', 'stocks', 'categories'));

    }

    public function actionUpdateProduct(Request $request, $productId )
    {
        $product = ProductModel::findOrFail($productId);
        $productDescription = $product->description()->firstOrFail();

        $productDescription->update($request->all());
        $product->update([$request->productSKU]);

        $productCategory = CategoryModel::findOrFail($request->productCategory);
        $product->category()->associate($productCategory);

        $productBrand = ProductBrandsModel::findOrFail($request->productBrand);
        $product->brand()->associate($productBrand);

        $gender = ProductGenderModel::findOrFail($request->productGender);
        $product->gender()->associate($gender);

        $stock = ProductStockModel::findOrFail($request->productStock);
        $product->stock()->associate($stock);

        Session::flash('message', 'Продукт был успешно обновлен');
        return redirect()->back();
    }

}