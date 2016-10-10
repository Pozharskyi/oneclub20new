<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 08.09.2016
 * Time: 12:16
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Notifications\ESputnik\NotificationsConfigController;

class NotificationsConfigTest extends TestCase
{
    /**
     * Getting notifications config
     * If real
     */
    public function testGettingConfig()
    {
        $config = NotificationsConfigController::getConfig();

        $real_config = array(
            'username' => 'v.kolokoltseva@oneclub.ua',
            'password' => '123456',
        );

        $this->assertEquals( $config, $real_config );

    }

}