<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 15:43
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsOptionsTest extends TestCase
{
    /**
     * Testing if getting options
     * For notifications
     */
    public function testOptionsSucceed()
    {
        $result = true;

        try {
            $this->visit('/admin/notifications/options/1/1')
                ->see('TEMPLATE');
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    /**
     * Testing if getting
     * options for notifications fails
     * by incorrect Event
     */
    public function testOptionsFailed()
    {
        $result = true;

        try {
            $this->visit('/admin/notifications/options/1/10')
                ->see('Выберите параметры');
        } catch( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

}