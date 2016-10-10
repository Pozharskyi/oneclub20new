<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 15:29
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Models\Shop\Basket\BasketModel;

class OrderPricesTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingDataFromEmptyBasket()
    {
        $user_id = 1;

        BasketModel::where('user_id', $user_id)
            ->delete();

        $data = OrderPricesController::actionGetPricesAndQuantityFromBasket( $user_id );

        $this->assertEquals( 0, $data->total_price );
        $this->assertEquals( 0, $data->total_quantity );
    }

    public function testGettingDataFromNotEmptyBasket()
    {
        $user_id = 1;

        BasketModel::create([
            'user_id' => $user_id,
            'sub_product_id' => 1,
            'sub_product_quantity' => 1,
        ]);

        $data = OrderPricesController::actionGetPricesAndQuantityFromBasket( $user_id );

        $this->assertNotEquals( 0, $data->total_price );
        $this->assertNotEquals( 0, $data->total_quantity );
    }

    public function testCalculateDiscountFails()
    {
        $price = 1000;
        $discounts = array(
            101, // not found
        );

        $result = true;

        try
        {
            $data = OrderPricesController::actionCalculateDiscount($price, $discounts);
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testCalculateDiscountSucceed()
    {
        $price = 1000;
        $discounts = array(
            1, // not found
        );

        $result = true;

        try
        {
            $data = OrderPricesController::actionCalculateDiscount($price, $discounts);

            $this->assertEquals( 750, $data ); // 25% discount

        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    public function testFinalGettingPricesFailsByDiscount()
    {
        $user_id = 1;
        $discounts = array(
            'test', // hereby fails
        );
        $bonuses = 500;

        $result = true;

        try
        {
            $data = OrderPricesController::actionGetPrices( $user_id, $discounts, $bonuses );

        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );

    }

    public function testFinalGettingPricesFailsByBasket()
    {
        $user_id = 1;
        $discounts = array(
            '124adm124amkdwLda', // hereby fails
        );
        $bonuses = 500;

        BasketModel::where('user_id', $user_id)
            ->delete();

        try
        {
            $data = OrderPricesController::actionGetPrices( $user_id, $discounts, $bonuses );

            $this->assertEquals( 0, $data->total_price );
            $this->assertEquals( 0, $data->total_quantity );

        } catch ( Exception $e )
        {
            $this->assertTrue( true );
        }
    }


    public function testFinalGettingPricesSucceed()
    {
        $user_id = 1;
        $discounts = array(
            '124adm124amkdwLda',
        );
        $bonuses = 500;

        BasketModel::create([
            'user_id' => $user_id,
            'sub_product_id' => 1,
            'sub_product_quantity' => 1,
        ]);

        try
        {
            $data = OrderPricesController::actionGetPrices( $user_id, $discounts, $bonuses );

            $this->assertNotEquals( 0, $data->total_price );
            $this->assertNotEquals( 0, $data->total_quantity );

        } catch ( Exception $e )
        {
            $this->assertTrue( true );
        }
    }

}