<?php

use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Models\Order\OrderModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminOrderAddSubProductWithDiscountTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddSubProductToOrderWithDiscountSucceed()
    {
        list($user, $order, $product, $subProduct, $discount) = $this->setData();

        $parameters = [
            'quantity' => 1,        //TODO check what quantity is available
            'color' => $subProduct->color()->first()->id,
            'size' => $subProduct->size()->first()->id,
            'product_id' => $product->id,
            '_token' => csrf_token(),
        ];

        $this->call('post', route('adminPanel.subproduct.add', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        //Update total_quantity succeed
        $this->seeInDatabase('dev_order_index',
            ['id' => $order->id, 'total_quantity' => $order->total_quantity + $parameters['quantity']]);

        //Update original_sum
        $original_sum = $order->original_sum + $subProduct->price()->first()->special_price * $parameters['quantity'];
        $newOrder = \App\Models\Order\OrderModel::findOrFail($order->id);
        $this->assertEquals($original_sum, $newOrder->original_sum);
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'original_sum' => $original_sum]);

        //Update total_sum Succeed
        $total_sum = $order->original_sum + $subProduct->price()->first()->special_price * $parameters['quantity']; //get new price without discount

        $total_price_with_discount = OrderPricesController::actionCalculateDiscount($total_sum, $discount); //TODO test actionCalculateDiscount function

        $newOrder = OrderModel::find($order->id);
        $this->assertEquals($newOrder->total_sum, $total_price_with_discount);
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'total_sum' => $total_price_with_discount]);

        //Update quantity in sub_product_table
        $quantity = $subProduct->quantity - $parameters['quantity'];
        $this->seeInDatabase('dev_sub_product', ['id' => $subProduct->id, 'quantity' => $quantity]);
    }

    /**
     * failed because current discount not valid for new price
     */
    public function testAddSubProductToOrderWithDiscountFailed()
    {
        list($user, $order, $product, $subProduct, $discount) = $this->setData();

        $parameters = [
            'quantity' => 1,        //TODO check what quantity is available
            'color' => $subProduct->color()->first()->id,
            'size' => $subProduct->size()->first()->id,
            'product_id' => $product->id,
            '_token' => csrf_token(),
        ];

        $discount->max_basket_sum = $order->original_sum + 1;   //set max_basket_sum for no more subProducts adding
        $discount->save();

        $this->call('post', route('adminPanel.subproduct.add', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        //Don't Update total_quantity succeed
        $this->seeInDatabase('dev_order_index',
            ['id' => $order->id, 'total_quantity' => $order->total_quantity]);

        //Don't Update original_sum
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'original_sum' => $order->original_sum]);

        //Don't Update total_sum
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'total_sum' => $order->total_sum]);

        //Don't Update quantity in sub_product_table
        $subProductNew = \App\Models\Product\SubProductModel::find($subProduct->id);
        $this->seeInDatabase('dev_sub_product', ['id' => $subProduct->id, 'quantity' => $subProductNew->quantity]);

        $this->seeInSession('message', 'При добавлении товара текущая скидка будет недоступна, необходимо сначала убрать скидку');
    }

//    /**
//     * should add subProduct to order with discount and balance amount
//     */
//    public function testAddSubProductWithBalanceSucceed()
//    {
//        list($user, $order, $product, $subProduct, $discount) = $this->setData();
//    }



    /**
     * @return array
     */
    private function setData()
    {
        //START SECTION login new user as СуперАдмин
        $role = factory(\App\Models\User\RoleModel::class)->create();
        $user = factory(\App\User::class)->create();
        $user->roles()->attach($role);
        $this->assertTrue($user->hasRole('СуперАдмин'));
        $this->be($user);
        //END LOGIN SECTION

        //create order with paymentType
        $order = factory(\App\Models\Order\OrderModel::class)->make();
        $paymentType = factory(\App\Models\Payment\PaymentTypesModel::class)->create();
        $order->orderPaymentType()->associate($paymentType);
        $order->user()->associate($user);
        $order->save();

        //START SECTION SAVE PRODUCT IN DB
        $product = factory(\App\Models\Product\ProductModel::class)->make();
        $brand = factory(\App\Models\Product\ProductBrandsModel::class)->create();
        $category = factory(\App\Models\Category\CategoryModel::class)->create();
        $stock = factory(\App\Models\Product\ProductStockModel::class)->create();
        $gender = factory(\App\Models\Basic\BasicGenderModel::class)->create();
        $product->brand()->associate($brand);
        $product->category()->associate($category);
        $product->stock()->associate($stock);
        $product->gender()->associate($gender);
        $product->save();
        $productDescription = factory(\App\Models\Product\ProductDescriptionModel::class)->make();
        $productDescription->product()->associate($product);
        $productDescription->save();
        //END SECTION SAVE PRODUCT IN DB

        //START SUB_PRODUCT SAVE IN DB SECTION
        $color = factory(\App\Models\Product\ProductColorModel::class)->create();
        $size = factory(\App\Models\Product\ProductSizeModel::class)->create();
        $subProduct = factory(\App\Models\Product\SubProductModel::class)->make();
        $subProduct->color()->associate($color);
        $subProduct->size()->associate($size);
        $subProduct->product()->associate($product);
        $subProduct->save();
        $productPopularity = factory(\App\Models\Product\ProductPopularityModel::class)->make();
        $productPopularity->sub_product_id = $subProduct->id;
        $productPopularity->save();
        $photo = factory(\App\Models\Product\ProductPhotoModel::class)->make();
        $photo->subProduct()->associate($subProduct);
        $photo->save();
        $prices = factory(\App\Models\Product\ProductIndexPricesModel::class)->make();
        $prices->subProduct()->associate($subProduct);
        $prices->save();
        //END SUB_PRODUCT SAVE IN DB SECTION

        //START DISCOUNT SECTION
        $couponRule = factory(\App\Models\Discount\CouponRuleModel::class)->create();
        $discount = factory(\App\Models\Discount\DiscountsModel::class)->make();
        $discount->couponRule()->associate($couponRule);
        $discount->save();
        $order->discount()->associate($discount);

        //calculate order total_sum with discount
        $discountClone = $discount->replicate();
        $order->total_sum = OrderPricesController::actionCalculateDiscount($order->total_sum, $discountClone);
        $order->save();

        return array($user, $order, $product, $subProduct, $discount);
    }
}
