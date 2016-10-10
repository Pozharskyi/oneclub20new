<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Requests\Product\CreateSubProductRequest;
use App\Http\Requests\Product\UpdateSubProductRequest;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductModel;
use App\Models\Product\ProductSizeModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use View;

class AdminPanelSubProductController extends Controller
{
    public function getSubProduct(Request $request, $userId, $orderId, $subProductId)
    {
        $subProduct = SubProductModel::with('photos', 'statusOrderSubProduct')->findOrFail($subProductId);
        return view('admin.panel.subproducts.index', compact('subProduct', 'userId', 'orderId'));
    }

    public function createSubProduct(Request $request)
    {
        $sizes = ProductSizeModel::all();
        $colors = ProductColorModel::all();
        $products = ProductModel::all();

        return view('admin.panel.subproducts.create', compact('sizes', 'colors', 'products'));
    }
    public function storeSubProduct(CreateSubProductRequest $request)
    {
        $subProduct = new SubProductModel($request->all());

        $size = ProductSizeModel::findOrFail($request->size);
        $color = ProductColorModel::findOrFail($request->color);
        $product = ProductModel::findOrFail($request->product);

        $subProduct->size()->associate($size);
        $subProduct->color()->associate($color);
        $subProduct->product()->associate($product);
        $subProduct->save();

        Session::flash('message', 'Субпродукт был успешно создан');

        return redirect()->back();
    }

    public function editSubProducts(Request $request, $productId, $subProductId)
    {
        $subProduct = SubProductModel::findOrFail($subProductId);

        $product = ProductModel::findOrFail($productId);
        $sizes = ProductSizeModel::all();
        $colors = ProductColorModel::all();
        $products = ProductModel::all();

        return view('admin.panel.subproducts.edit', compact('sizes', 'colors', 'products', 'product', 'subProduct'));
    }

    public function updateSubProducts(Request $request, $productId, $subProductId)
    {
        $subProduct = SubProductModel::findOrFail($subProductId);

        $subProduct->fill($request->all());

        $size = ProductSizeModel::findOrFail($request->size);
        $color = ProductColorModel::findOrFail($request->color);
        $product = ProductModel::findOrFail($request->product);

        $subProduct->size()->associate($size);
        $subProduct->color()->associate($color);
        $subProduct->product()->associate($product);
        $subProduct->save();

        return redirect()->back();
    }

    public function getSubProductsList($productId)
    {
        $product = ProductModel::findOrFail($productId);

        $subProducts = $product->subProducts()->with(['price'])->get();

        return response()->json(View::make('admin.panel.subproducts.list', compact('subProducts', 'product'))->render());
    }
}
