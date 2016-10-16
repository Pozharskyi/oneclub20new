<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminOrderAddSubProductTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSeeAddSubProductViewSucceed()
    {
        list($user, $order, $product, $subProduct) = $this->setData();


        $parameters = [
            'searchString' => $product->product_store_id,
            '_token' => csrf_token(),
        ];

        $this->call('post', route('adminPanel.subproduct.add.show', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        $this->seePageIs('/admin/users/' . $user->id . '/orders/' . $order->id . '/add_product');
    }

    public function testSeeAddSubProductViewFailed()
    {
        list($user, $order, $product, $subProduct) = $this->setData();


        $parameters = [
            'searchString' => 'not valid product id',
            '_token' => csrf_token(),
        ];

        $this->call('post', route('adminPanel.subproduct.add.show', ['user' => $user->id, 'order' => $order->id]),
            $parameters);
        $this->seeInSession('message', 'Не верный № продукта');

    }

    public function testAddSubProductToOrderWithNoDiscountSucceed()
    {
        list($user, $order, $product, $subProduct) = $this->setData();

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
        $total_sum = $order->total_sum + $subProduct->price()->first()->special_price * $parameters['quantity'];
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'total_sum' => $total_sum]);

        //Update quantity in sub_product_table
        $quantity = $subProduct->quantity - $parameters['quantity'];
        $this->seeInDatabase('dev_sub_product', ['id' => $subProduct->id, 'quantity' => $quantity]);
    }

    //if quantity don't valid - rollBack transaction
    public function testAddSubProductToOrderWithNoDiscountFailed()
    {
        list($user, $order, $product, $subProduct) = $this->setData();

        $parameters = [
            'quantity' => 100,        //not valid quantity
            'color' => $subProduct->color()->first()->id,
            'size' => $subProduct->size()->first()->id,
            'product_id' => $product->id,
            '_token' => csrf_token(),
        ];

        $this->call('post', route('adminPanel.subproduct.add', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        //Don't Update total_quantity succeed
        $this->seeInDatabase('dev_order_index',
            ['id' => $order->id, 'total_quantity' => $order->total_quantity]);

        //Don't Update original_sum
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'original_sum' => $order->original_sum]);

        //Don't Update total_sum
        $this->seeInDatabase('dev_order_index', ['id' => $order->id, 'total_sum' => $order->total_sum]);

        //Update quantity in sub_product_table
        $subProductNew = \App\Models\Product\SubProductModel::find($subProduct->id);
        $this->seeInDatabase('dev_sub_product', ['id' => $subProduct->id, 'quantity' => $subProductNew->quantity]);

        $this->seeInSession('message', 'Произошла ошибка попробуйте добавить еще раз');
    }

    //create orderSubProduct after added subProduct if there was NO orderSubProduct (for this order and subProduct)
    public function testAfterAddedSubProductShouldCreateOrderSubProductSucceed()
    {
        list($user, $order, $product, $subProduct) = $this->setData();

        $parameters = [
            'quantity' => 1,        //TODO check what quantity is available
            'color' => $subProduct->color()->first()->id,
            'size' => $subProduct->size()->first()->id,
            'product_id' => $product->id,
            '_token' => csrf_token(),
        ];


        $this->call('post', route('adminPanel.subproduct.add', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        $this->seeInDatabase('dev_order_index_sub_product',
            [
                'qty' => $parameters['quantity'],
                'dev_order_index_id' => $order->id,
                'dev_sub_product_id' => $subProduct->id,
            ]);
    }

    //update orderSubProduct after added subProduct if there was orderSubProduct (for this order and subProduct)
    public function testAfterAddedSubProductShouldUpdateOrderSubProduct()
    {
        list($user, $order, $product, $subProduct) = $this->setData();

        $parameters = [
            'quantity' => 1,        //TODO check what quantity is available
            'color' => $subProduct->color()->first()->id,
            'size' => $subProduct->size()->first()->id,
            'product_id' => $product->id,
            '_token' => csrf_token(),
        ];

        //create orderSubProduct in DB
        $orderSubProduct = factory(\App\Models\Order\OrderIndexSubProductModel::class)->make();
        $orderSubProduct->order()->associate($order);
        $orderSubProduct->subProduct()->associate($subProduct);
        $orderSubProduct->save();

        $this->call('post', route('adminPanel.subproduct.add', ['user' => $user->id, 'order' => $order->id]),
            $parameters);

        $this->seeInDatabase('dev_order_index_sub_product',
            [
                'id' => $orderSubProduct->id,
                'qty' => $orderSubProduct->qty + $parameters['quantity'],
                'dev_order_index_id' => $order->id,
                'dev_sub_product_id' => $subProduct->id,
            ]);
    }

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

        return array($user, $order, $product, $subProduct);
        //END SUB_PRODUCT SAVE IN DB SECTION
    }

}
