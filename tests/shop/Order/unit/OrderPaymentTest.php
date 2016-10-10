<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 15:25
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderPaymentController;
use \Illuminate\Http\Request;

class OrderPaymentTest extends TestCase
{
    public function testIfPaymentSaveFailsByOrder()
    {
        $order_id = 101;

        $request = new Request;
        $request['payment_type'] = 1;

        $result = true;

        try {
            OrderPaymentController::actionSaveOrderPayment( $order_id, $request );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testIfPaymentSaveFailsByPaymentType()
    {
        $order_id = 1;

        $request = new Request;
        $request['payment_type'] = 101;

        $result = true;

        try {
            OrderPaymentController::actionSaveOrderPayment( $order_id, $request );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testIfPaymentSaveSucceed()
    {
        $order_id = 1;

        $request = new Request;
        $request['payment_type'] = 1;

        $result = true;

        try {
            OrderPaymentController::actionSaveOrderPayment( $order_id, $request );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

}