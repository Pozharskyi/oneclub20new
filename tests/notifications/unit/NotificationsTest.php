<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 12:40
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Notifications\ESputnik\NotificationsIndexController;

class NotificationsTest extends TestCase
{
    /**
     * Testing if user sends
     * right data for route
     */
    public function testUserIncorrectSending()
    {
        $exception = false;

        try
        {
            $this->visit('/notifications/abs/abs');
        } catch( Exception $e )
        {
            $exception = true;
        }

        $this->assertTrue( $exception );
    }

    /**
     * Testing if user correct sends
     * data
     */
    public function testUserCorrectSending()
    {
        $exception = true;

        try
        {
            $this->visit('/notifications/1/2');
        } catch( Exception $e )
        {
            $exception = false;
        }

        $this->assertTrue( $exception );
    }

    /**
     * Testing notifications types
     */
    public function testNotificationType()
    {
        $notification = new NotificationsIndexController;

        $types = $notification->actionFindMessagesTypesForTrigger( 1 );

        foreach( $types as $data ) {

            $this->assertEquals( 1, $data->notification_type_id );
        }
    }

    /**
     * Testing user data
     * Success
     */
    public function testUserData()
    {
        $notification = new NotificationsIndexController;

        $email = $notification->actionGetUserData( 1, 2 );
        $phone = $notification->actionGetUserData( 1, 3 );

        $real_email = 'serdiuk.oleksandr@gmail.com';
        $real_phone = null;

        $this->assertEquals( $real_email, $email );
        $this->assertNotEquals( $real_email, $phone );

        $this->assertEquals( $real_phone, $phone );
        $this->assertNotEquals( $real_phone, $email );
    }

}