<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 16:47
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderController;
use \Illuminate\Http\Request;
use App\User;

class OrderIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testSaveOrderIndexFailsByUserId()
    {
        $result = true;

        try
        {
            $this->actingAs( User::find(101) );

            $order = new OrderController;

            $public_order_id = '1234-1234-1234-1234';

            $request = new Request;
            $request['comment'] = 'Test';

            $total = new stdClass;
            $total->total_sum = 1234;
            $total->total_quantity = 1234;

            $order->actionInsertOrder( $public_order_id, $request, $total );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testSaveOrderIndexSucceed()
    {
        $result = true;

        try
        {
            $this->actingAs( User::find(1) );

            $order = new OrderController;

            $public_order_id = '1234-1234-1234-1234';

            $request = new Request;
            $request['comment'] = 'Test';

            $total = new stdClass;
            $total->total_sum = 1234;
            $total->total_quantity = 1234;

            $order->actionInsertOrder( $public_order_id, $request, $total );
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testEncryptionFails()
    {
        $result = true;

        try {
            $order = new OrderController;

            $hash = $order->actionGetPublicOrderId('1');

            $this->assertNotEquals( 'Z', substr( $hash, 0, 1 ) );
            $this->assertNotEquals( 19, strlen( $hash ) );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testEncryptionSucceed()
    {
        $order = new OrderController;

        $hash = $order->actionGetPublicOrderId('380950948268');

        $this->assertEquals( 'Z', substr( $hash, 0, 1 ) );
        $this->assertEquals( 19, strlen( $hash ) );
    }

}