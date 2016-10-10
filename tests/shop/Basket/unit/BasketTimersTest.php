<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 0:29
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class BasketTimersTest extends TestCase
{
    public function testUserBeforeAuthFails()
    {
        $request = $this->call('GET', '/basket/timers');

        $this->assertEquals( 302, $request->status() );
    }

    public function testUserAfterAuthOkStatus()
    {
        $user = User::find(1);

        $request = $this->actingAs( $user )
            ->call('GET', '/basket/timers');

        $this->assertEquals( 200, $request->status() );
    }

}