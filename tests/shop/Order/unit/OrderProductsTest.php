<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 16:04
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderProductsController;
use App\Models\Shop\Basket\BasketModel;
use App\Models\Product\SubProductModel;

class OrderProductsTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingProductFromBasketFails()
    {
        $user_id = 1;

        BasketModel::where('user_id', $user_id)
            ->delete();

        $products = OrderProductsController::actionGetBasketProducts( $user_id );

        $this->assertFalse( $products );
    }

    public function testGettingProductFromBasketSucceed()
    {
        $user_id = 1;

        BasketModel::create([
            'user_id' => $user_id,
            'sub_product_quantity' => 1,
            'sub_product_id' => 1,
        ]);

        $products = OrderProductsController::actionGetBasketProducts( $user_id );

        $this->assertNotFalse( $products );
    }

    public function testProductAvailabilityFails()
    {
        $user_id = 1;

        BasketModel::create([
            'user_id' => $user_id,
            'sub_product_quantity' => 101, // hereby fails
            'sub_product_id' => 1,
        ]);

        $result = OrderProductsController::actionValidateProductsAvailability( $user_id );

        $this->assertFalse( $result );
    }

    public function testProductAvailabilitySucceed()
    {
        $user_id = 1;

        BasketModel::where('user_id', $user_id)
            ->delete();

        BasketModel::create([
            'user_id' => $user_id,
            'sub_product_quantity' => 1, // hereby fails
            'sub_product_id' => 1,
        ]);

        $result = OrderProductsController::actionValidateProductsAvailability( $user_id );

        $this->assertNotFalse( $result );
    }

    public function testProductUpdateQuantityFails()
    {
        $sub_product_id = 101;
        $sub_product_quantity = 1;

        $result = true;

        try {
            $products = array();
            $products[0] = new stdClass;
            $products[0]->sub_product_id = $sub_product_id;
            $products[0]->sub_product_quantity = $sub_product_quantity;

            $data = SubProductModel::find($sub_product_id);
            $quantity = $data->quantity;

            OrderProductsController::actionUpdateProductsQuantity($products);

            $new_data = SubProductModel::find($sub_product_id);
            $new_quantity = $new_data->quantity;

            $this->assertNotEquals($quantity, $new_quantity);
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );

    }

    public function testProductUpdateQuantitySucceed()
    {
        $sub_product_id = 1;
        $sub_product_quantity = 1;

        $products = array();
        $products[0] = new stdClass;
        $products[0]->sub_product_id = $sub_product_id;
        $products[0]->sub_product_quantity = $sub_product_quantity;

        $data = SubProductModel::find( $sub_product_id );
        $quantity = $data->quantity;

        OrderProductsController::actionUpdateProductsQuantity( $products );

        $new_data = SubProductModel::find( $sub_product_id );
        $new_quantity = $new_data->quantity;

        $this->assertNotEquals( $quantity, $new_quantity );

    }

    public function testProductInsertingFailsByOrder()
    {
        $order_id = 101; // hereby fails
        $products = array(
            1, 2,
        );

        $result = true;

        try {
            OrderProductsController::actionInsertProducts($order_id, $products);
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testProductInsertingFailsByProducts()
    {
        $order_id = 101;
        $products = array( // hereby fails
            101, 202,
        );

        $result = true;

        try {
            OrderProductsController::actionInsertProducts($order_id, $products);
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testProductInsertingSucceed()
    {
        $order_id = 1; // hereby fails
        $products = array(
            1, 2,
        );

        $result = true;

        try {
            OrderProductsController::actionInsertProducts($order_id, $products);
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );

        $this->seeInDatabase('dev_order_index_sub_product', [
            'dev_sub_product_id' => 1,
            'dev_order_index_id' => 1,
        ]);

        $this->seeInDatabase('dev_order_index_sub_product', [
            'dev_sub_product_id' => 2,
            'dev_order_index_id' => 1,
        ]);
    }

    public function testGettingProductPricesFailsByInvalidProduct()
    {
        $products = array(
            101, 202 // hereby fails
        );

        $result = true;

        try {
            $prices = OrderProductsController::actionGetPricesForProducts($products);

            $this->assertEquals(count($products), count($prices));
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testGettingProductPricesSucceed()
    {
        $products = array(
            1, 2 // hereby fails
        );

        $result = true;

        try {
            $prices = OrderProductsController::actionGetPricesForProducts($products);

            $this->assertEquals(count($products), count($prices));
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    public function testGettingParentIdFailsByIncorrectProduct()
    {
        $sub_product = 101; // hereby fails

        $result = true;

        try
        {
            $parent_id = OrderProductsController::actionFindParentIdBySubProduct($sub_product);

            $this->assertNotFalse( $parent_id );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testGettingParentIdSucceed()
    {
        $sub_product = 1; // hereby fails

        $result = true;

        try
        {
            $parent_id = OrderProductsController::actionFindParentIdBySubProduct($sub_product);

            $this->assertNotFalse( $parent_id );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

}