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
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductDescriptionModel;
use App\Models\Product\ProductModel;
use DB;
use Illuminate\Http\Request;

use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductSizeModel;
use App\Models\Product\ProductGenderModel;

use App\Models\Product\ProductBrandsModel;
use App\Models\Product\ProductStockModel;
use Session;

class AdminProductsCreateController extends Controller
{
    public function actionGetCreateProductForm()
    {
        $categories = CategoryModel::orderBy('id')->get();

        $genders = ProductGenderModel::orderBy('id')->get();
        $brands = ProductBrandsModel::orderBy('id')->get();
        $stocks = ProductStockModel::orderBy('id')->get();

        return view('admin.panel.products.read', [
            'categories' => $categories,
            'genders' => $genders,

            'brands' => $brands,
            'stocks' => $stocks,
        ]);
    }

//    public function actionGetSubProductView( $id )
//    {
//        $colors = ProductColorModel::orderBy('id')->get();
//        $sizes = ProductSizeModel::orderBy('id')->get();
//
//        $id++;
//
//        return view('admin.panel.products.sub_read', [
//            'id' => $id,
//            'colors' => $colors,
//            'sizes' => $sizes,
//        ]);
//    }


    public function actionCreateProduct(Request $request)
    {
        DB::transaction(function () use ($request) {

            $productDescription = new ProductDescriptionModel($request->all());
            $product = new ProductModel();

            $productBrand = ProductBrandsModel::findOrFail($request->productBrand);
            $product->brand()->associate($productBrand);

            $productCategory = CategoryModel::findOrFail($request->productCategory);
            $product->category()->associate($productCategory);

            $product->sku = $request->productSKU;
            $product->product_store_id = random_int(10000000, 99999999);
            $product->product_backend_id = random_int(10000000, 99999999);

            $product->save();

            $gender = ProductGenderModel::findOrFail($request->productGender);
            $product->gender()->associate($gender);

            $stock = ProductStockModel::findOrFail($request->productStock);
            $product->stock()->associate($stock);


            $productDescription->product()->associate($product);
            $productDescription->save();
        });

        Session::flash('message', 'Продукт был успешно создан');
        return redirect()->back();
    }

}