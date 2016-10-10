<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 1:03
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Users\UsersBonusesController;

class UsersBonusesTest extends TestCase
{
    public function testUserBonusesFails()
    {
        $data = UsersBonusesController::actionGetUserBonuses( 1001 );

        $this->assertEquals( 0, $data );
    }

    public function testUserBonusesSucceed()
    {
        $data = UsersBonusesController::actionGetUserBonuses( 1 );

        $this->assertNotEquals( 0, $data );
    }

}