<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 23:59
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class BasketIndexTest extends TestCase
{
    public function testPermissionsFails()
    {
        $request = $this->call('GET', '/basket');

        $this->assertEquals( 302, $request->status() );
    }

    public function testPermissionsSuccess()
    {
        $user = User::FindOrFail(1);

        $this->actingAs( $user )
            ->visit('/basket')
            ->assertResponseStatus( 200 );
    }

    public function testGettingView()
    {
        $user = User::FindOrFail(1);

        $this->actingAs( $user )
            ->visit('/basket')
            ->see('<a href="/checkout">');
    }

}