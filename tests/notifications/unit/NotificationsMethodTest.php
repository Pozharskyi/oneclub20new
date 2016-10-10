<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 14:39
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Notifications\NotificationsMethodController;

class NotificationsMethodTest extends TestCase
{
    /**
     * If request type
     * is invalid
     */
    public function testFailedRequestType()
    {
        $result = NotificationsMethodController::actionGetUserData( 'getPhone', 1 );

        $this->assertFalse( $result );
    }

    /**
     * If request type is ok
     */
    public function testRightRequestType()
    {
        $result = NotificationsMethodController::actionGetUserData( 'getFullName', 1 );

        $this->assertNotFalse( $result );
    }

    /**
     * Testing for getting Full name
     */
    public function testGettingFullName()
    {
        $result = NotificationsMethodController::actionGetUserData( 'getFullName', 1 );

        $this->assertEquals( 'Oleksandr Serdiuk', $result );
    }

    /**
     * testing for getting First name
     */
    public function testGettingFirstName()
    {
        $result = NotificationsMethodController::actionGetUserData( 'getFirstName', 1 );

        $this->assertEquals( 'Oleksandr', $result );
    }

    /**
     * Testing for getting last name
     */
    public function testGettingLastName()
    {
        $result = NotificationsMethodController::actionGetUserData( 'getLastName', 1 );

        $this->assertEquals( 'Serdiuk', $result );
    }

}