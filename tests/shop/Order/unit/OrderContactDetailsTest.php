<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 14:39
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderContactDetailsController;
use \Illuminate\Http\Request;

class OrderContactDetailsTest extends TestCase
{
    use DatabaseTransactions;

    public function testSavingContactDetailsFails()
    {
        $order_id = 101;

        $request = new Request;

        $request['f_name'] = 'Oleksandr';
        $request['l_name'] = 'Serdiuk';
        $request['city'] = 'Kiev';
        $request['cell'] = '380950948268';
        $request['email'] = 'serdiuk@gmail.com';

        $result =true;

        try {
            OrderContactDetailsController::actionSaveContactDetails( $order_id, $request );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );

    }

    public function testSavingContactDetails()
    {
        $order_id = 1;

        $request = new Request;

        $request['f_name'] = 'Oleksandr';
        $request['l_name'] = 'Serdiuk';
        $request['city'] = 'Kiev';
        $request['cell'] = '380950948268';
        $request['email'] = 'serdiuk@gmail.com';

        $result =true;

        try
        {
            OrderContactDetailsController::actionSaveContactDetails( $order_id, $request );
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );

    }

}