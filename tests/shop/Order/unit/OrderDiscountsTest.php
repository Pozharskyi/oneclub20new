<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 15:05
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderDiscountsController;

class OrderDiscountsTest extends TestCase
{
    use DatabaseTransactions;

    public function testDiscountsSearchFail()
    {
        $discounts = ['124adm124amkdwLda', 'test']; // fails with test discount

        $ids = OrderDiscountsController::actionFindDiscounts( $discounts );

        $this->assertNotEquals( 2, count( $ids ) );
    }

    public function testDiscountsSearchSucceed()
    {
        $discounts = ['124adm124amkdwLda', 'damkpw4193laddaw']; // fails with test discount

        $ids = OrderDiscountsController::actionFindDiscounts( $discounts );

        $this->assertEquals( 2, count( $ids ) );
    }

    public function testDiscountsUpdateFails()
    {
        $discounts = array(
            'test',
        );

        $result = true;

        try {
            OrderDiscountsController::actionUpdateDiscounts( $discounts );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testDiscountsUpdateSucceed()
    {
        $discounts = array(
            1,
        );

        $result = true;

        try {
            OrderDiscountsController::actionUpdateDiscounts( $discounts );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    public function testDiscountsInsertingFailsByOrder()
    {
        $order_id = 101;
        $discounts = array(
            1
        );

        $result = true;

        try {
            OrderDiscountsController::actionInsertDiscounts( $order_id, $discounts );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testDiscountsInsertingFailsByDiscount()
    {
        $order_id = 1;
        $discounts = array(
            101
        );

        $result = true;

        try {
            OrderDiscountsController::actionInsertDiscounts( $order_id, $discounts );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testDiscountsInsertingSucceed()
    {
        $order_id = 1;
        $discounts = array(
            1
        );

        $result = true;

        try {
            OrderDiscountsController::actionInsertDiscounts( $order_id, $discounts );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

}