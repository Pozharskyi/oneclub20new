<?php

namespace App\Http\Controllers\Admin\Panel\Order;

use App\Http\Controllers\Shop\Order\OrderBalanceController;
use App\Http\Controllers\Shop\Order\OrderContactDetailsController;
use App\Http\Controllers\Shop\Order\OrderDeliveryController;
use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Http\Controllers\Shop\Order\OrderProductsController;
use App\Models\Order\OrderIndexSubProductModel;
use App\Models\Order\OrderModel;
use App\Models\Product\SubProductModel;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminAddSubProductController extends Controller
{
    public function addSubProduct(Request $request, $userId, $orderId)
    {
//        dd($request->all());
        $color_id = $request->color;
        $size_id = $request->size;
        $quantity = $request->quantity;
        $product_id = $request->product_id;

        $subProduct = SubProductModel::with(['price'])->where('dev_product_color_id', $color_id)
            ->where('dev_product_size_id', $size_id)->where('dev_product_index_id', $product_id)
            ->firstOrFail();

        $order = OrderModel::findOrFail($orderId);

//        dd($subProduct->price()->first()->special_price);
        // begin Transaction
        DB::beginTransaction();
        try {
//            if($order->discount_id){
//                $this->actionOrderConfirmWithDiscount($subProduct, $quantity, $orderId);
//            } else {
                $this->actionOrderConfirmWithNoDiscount($subProduct, $quantity, $orderId);
//            }
            // if succeed do
            DB::commit();
        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();
            Session::flash('message', 'Произошла ошибка попробуйте добавить еще раз');
            return redirect()->route('adminPanel.order.index', ['user' => $userId, 'order' => $orderId]);
        }
        Session::flash('message', 'Продукт успешно добавлен');
        return redirect()->route('adminPanel.order.index', ['user' => $userId, 'order' => $orderId]);

    }

    public function actionOrderConfirmWithNoDiscount($subProduct, $quantity, $orderId)
    {
        $basket_product = new \stdClass();
        $basket_product->sub_product_id = $subProduct->id;
        $basket_product->sub_product_quantity = $quantity;
        $basket_products = Collection::make();
        $basket_products->add($basket_product);

        OrderProductsController::actionUpdateProductsQuantity($basket_products);
        $total = $this->actionGetPricesWithNoDiscount($subProduct, $quantity);

        $this->actionUpdateOrder($orderId, $total);

        $this->actionInsertSubProducts($orderId, $subProduct);

    }

    public function actionUpdateOrder($orderId, $total)
    {
        $order = OrderModel::findOrFail($orderId);

        $order->comment = 'Добавлен продукт';
        $order->total_sum += $total->total_price;
        $order->original_sum += $total->original_sum;
        $order->total_quantity += $total->total_quantity;

        $order->update();
    }


    public function actionGetPricesWithNoDiscount($subProduct, $quantity)
    {
        $total = new \stdClass();
        $total->total_price = $subProduct->price()->first()->special_price * $quantity;
        $total->total_quantity = $quantity;
        $total->original_sum = $total->total_price;

        return $total;
    }

    public function actionInsertSubProducts($orderId, $subProduct)
    {
        OrderIndexSubProductModel::create([
            'dev_sub_product_id' => $subProduct->id,
            'dev_order_index_id' => $orderId,
            'price_for_one_product' => $subProduct->price()->first()->special_price,
            'qty' => $subProduct->quantity,
        ]);
    }
}
