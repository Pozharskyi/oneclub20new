<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 15:00
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderDeliveryController;
use \Illuminate\Http\Request;

class OrderDeliveryTest extends TestCase
{
    use DatabaseTransactions;

    public function testOrderDeliverySaveFailsByOrder()
    {
        $order_id = 101;

        $request = new Request;

        $request['delivery_type'] = 1;
        $request['delivery_f_name'] = 'Oleksandr';
        $request['delivery_l_name'] = 'Serdiuk';
        $request['delivery_cell'] = '380950948268';
        $request['delivery_address'] = 'Dilova 5, apt. 102';

        $result =true;

        try {
            OrderDeliveryController::actionSaveOrderDelivery( $order_id, $request );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );

    }

    public function testOrderDeliverySaveFailsByDeliveryType()
    {
        $order_id = 1;

        $request = new Request;

        $request['delivery_type'] = 101;
        $request['delivery_f_name'] = 'Oleksandr';
        $request['delivery_l_name'] = 'Serdiuk';
        $request['delivery_cell'] = '380950948268';
        $request['delivery_address'] = 'Dilova 5, apt. 102';

        $result =true;

        try {
            OrderDeliveryController::actionSaveOrderDelivery( $order_id, $request );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );

    }

    public function testOrderDeliverySaveSucceed()
    {
        $order_id = 1;

        $request = new Request;

        $request['delivery_type'] = '1';
        $request['delivery_f_name'] = 'Oleksandr';
        $request['delivery_l_name'] = 'Serdiuk';
        $request['delivery_cell'] = '380950948268';
        $request['delivery_address'] = 'Dilova 5, apt. 102';

        $result =true;

        try {
            OrderDeliveryController::actionSaveOrderDelivery( $order_id, $request );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );

    }

}