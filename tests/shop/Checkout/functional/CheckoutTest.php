<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 0:39
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class CheckoutTest extends TestCase
{
    public function testUserAuthorizationFails()
    {
        $request = $this->call('GET', '/checkout');

        $this->assertEquals( 302, $request->status() );
    }

    public function testUserAuthorizationSucceed()
    {
        $user = User::find(1);

        $request = $this->actingAs( $user )
            ->call('GET', '/checkout');

        $this->assertEquals( 200, $request->status() );
    }

    public function testUserCheckoutIsGetting()
    {
        $user = User::find(1);

        $this->actingAs( $user )
            ->visit('/checkout')
            ->see('Oleksandr');
    }

}