<?php

namespace App\Http\Controllers\Admin\Panel\Order;

use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Http\Controllers\Shop\Order\OrderProductsController;
use App\Models\Discount\DiscountsModel;
use App\Models\Order\OrderIndexSubProductModel;
use App\Models\Order\OrderModel;
use App\Models\Product\SubProductModel;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminAddSubProductController extends Controller
{
    /**
     * add subProducts to order
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
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
            if($order->discount_id){
                $this->actionOrderConfirmWithDiscount($subProduct, $quantity, $orderId);
            } else {
                $this->actionOrderConfirmWithNoDiscount($subProduct, $quantity, $orderId);
            }
            // if succeed do
            DB::commit();
        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();
            if ($e instanceof ModelNotFoundException) {
                $e->getModel();
                if($e->getModel() == DiscountsModel::class){
                    Session::flash('message', 'При добавлении товара текущая скидка будет недоступна, необходимо сначала убрать скидку');
                }

            } else {
                Session::flash('message', 'Произошла ошибка попробуйте добавить еще раз');
            }
            return redirect()->route('adminPanel.order.index', ['user' => $userId, 'order' => $orderId]);
        }
        Session::flash('message', 'Продукт успешно добавлен');
        return redirect()->route('adminPanel.order.index', ['user' => $userId, 'order' => $orderId]);

    }

    public function actionOrderConfirmWithNoDiscount($subProduct, $quantity, $orderId)
    {
        //we need $basket_products for using actionUpdateProductsQuantity
        $basket_products = $this->makeBasketProductsCollection($subProduct, $quantity);

        OrderProductsController::actionUpdateProductsQuantity($basket_products);
        $total = $this->actionGetPricesWithNoDiscountBySubProduct($subProduct, $quantity);

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

    /**
     * create class that has prices fields for subProducts (with quantity)
     * @param $subProduct
     * @param $quantity
     * @return \stdClass
     *
     */
    public function actionGetPricesWithNoDiscountBySubProduct($subProduct, $quantity)
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

    public function actionOrderConfirmWithDiscount($subProduct, $quantity, $orderId)
    {

        //we need $basket_products for using actionUpdateProductsQuantity
        $basket_products = $this->makeBasketProductsCollection($subProduct, $quantity);

        // updating users data
        OrderProductsController::actionUpdateProductsQuantity($basket_products);

        $total = $this->actionGetPricesWithNoDiscountBySubProduct($subProduct, $quantity);

        $totalWithOrderData = $this->getTotalWithOrderData($total, $orderId);

        $order = OrderModel::findOrFail($orderId);
        $discountId = $order->discount_id;

        $discount = $this->isDiscountValid($totalWithOrderData, $discountId);


        //set prices that can be insert in Order (without calculation)
        $totalWithAllPrices = $this->getPriceWithDiscount($totalWithOrderData, $discount);

        //update order with $totalWithAllPrices
        $this->actionUpdateOrderWithAllPrices($totalWithAllPrices, $order);

        $this->actionInsertSubProducts($orderId, $subProduct);

    }

    /**
     * @param $subProduct
     * @param $quantity
     * @return static
     */
    private function makeBasketProductsCollection($subProduct, $quantity)
    {
        $basket_product = new \stdClass();
        $basket_product->sub_product_id = $subProduct->id;
        $basket_product->sub_product_quantity = $quantity;
        $basket_products = Collection::make();
        $basket_products->add($basket_product);
        return $basket_products;
    }

    public function getTotalWithOrderData($total, $orderId)
    {
        $order = OrderModel::findOrFail($orderId);

        $total->total_quantity += $order->total_quantity;
        $total->original_sum += $order->original_sum;
        $total->total_price = $total->original_sum;

        return $total;
    }

    /**
     * if discount is valid (check total price and quantity) return $discount
     * else throw exception
     * @param $totalWithOrderData
     * @param $discountId
     * @return
     */
    public function isDiscountValid($totalWithOrderData, $discountId)
    {
        $discount = DiscountsModel::where('id', $discountId)
            ->filterByBasketSum($totalWithOrderData->original_sum)
            ->filterBySubproductAmount($totalWithOrderData->total_quantity)
            ->firstOrFail();

        return $discount;
    }

    public function getPriceWithDiscount($totalWithOrderData, $discount)
    {
        $real_price = OrderPricesController::actionCalculateDiscount( $totalWithOrderData->total_price, $discount );

        $totalWithOrderData->total_price = $real_price;

        return $totalWithOrderData;
    }

    /**
     * update order's total_sum, original_sum, total_quantity
     * if order has orderBalance calculate it in total_price
     * @param $totalWithAllPrices
     * @param $order
     */
    public function actionUpdateOrderWithAllPrices($totalWithAllPrices, $order)
    {
        $orderBalance = $order->balance()->first();
        if($orderBalance){
            $totalWithAllPrices->total_price -= $orderBalance->balance_count;
        }
        $order->comment = 'Добавлен продукт';
        $order->total_sum = $totalWithAllPrices->total_price;
        $order->original_sum = $totalWithAllPrices->original_sum;
        $order->total_quantity = $totalWithAllPrices->total_quantity;

        $order->update();
    }

}
