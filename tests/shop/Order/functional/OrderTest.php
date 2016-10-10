<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 14:59
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class OrderTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthorizationForConfirmOrderFails()
    {
        $this->call('POST', '/list/order/save')
            ->isRedirection();
    }

    public function testAuthorizationSucceed()
    {
        $user = User::find(1);

        $request = $this->actingAs( $user )
            ->call('POST', '/list/order/save');

        $this->assertEquals( 500, $request->status() );
    }

    public function testSavingOrderFailsByPaymentType()
    {
        $user = User::find(1);

        try {
            $request = $this->actingAs($user)
                ->call('POST', '/list/order/save', [
                    'discounts' => '1,2',
                    'bonuses_used' => 100,
                    'cell' => '380950948268',

                    'f_name' => 'Oleksandr',
                    'l_name' => 'Serdiuk',
                    'city' => 'Kiev',
                    'email' => 'serdiuk@gmail.com',

                    'delivery_type' => 1,
                    'delivery_f_name' => 'Oleksandr',
                    'delivery_l_name' => 'Serdiuk',
                    'delivery_cell' => '380950948268',
                    'delivery_address' => 'Dilova 5, apt. 102',

                    'payment_type' => 101, // hereby fails
                ]);

            $this->assertEquals(500, $request->status());
        } catch ( Exception $e )
        {
            $this->assertTrue( true );
        }
    }

    public function testSavingOrderFailsByDeliveryType()
    {
        $user = User::find(1);

        try {
            $request = $this->actingAs( $user )
                ->call('POST', '/list/order/save', [
                    'discounts' => '1,2',
                    'bonuses_used' => 100,
                    'cell' => '380950948268',

                    'f_name' => 'Oleksandr',
                    'l_name' => 'Serdiuk',
                    'city' => 'Kiev',
                    'email' => 'serdiuk@gmail.com',

                    'delivery_type' => 101, // hereby fails
                    'delivery_f_name' => 'Oleksandr',
                    'delivery_l_name' => 'Serdiuk',
                    'delivery_cell' => '380950948268',
                    'delivery_address' => 'Dilova 5, apt. 102',

                    'payment_type' => 1,
                ]);

            $this->assertEquals( 500, $request->status() );
        } catch ( Exception $e )
        {
            $this->assertTrue( true );
        }
    }

    public function testSavingOrderSucceed()
    {
        $user = User::find(1);

        $request = $this->actingAs( $user )
            ->call('POST', '/list/order/save', [
                'discounts' => '1,2',
                'bonuses_used' => 100,
                'cell' => '380950948268',

                'f_name' => 'Oleksandr',
                'l_name' => 'Serdiuk',
                'city' => 'Kiev',
                'email' => 'serdiuk@gmail.com',

                'delivery_type' => 1,
                'delivery_f_name' => 'Oleksandr',
                'delivery_l_name' => 'Serdiuk',
                'delivery_cell' => '380950948268',
                'delivery_address' => 'Dilova 5, apt. 102',

                'payment_type' => 1,
            ]);

        $this->assertEquals( 200, $request->status() );
    }

}