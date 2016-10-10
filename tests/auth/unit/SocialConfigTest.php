<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Auth\Social\SocialConfigDataController;

define('SEARCH_EMAIL', 'serdiuk.oleksandr@gmail.com');

class SocialConfigTest extends TestCase
{
    /**
     * Testing if config exists
     * For real Social Provider
     *
     * @return void
     */
    public function testSocialConfigSucceed()
    {
        $success_config = SocialConfigDataController::getProviderConfig( 'google', 'XXX' );

        $this->assertNotEquals( $success_config, false );
    }

    /**
     * Testing if config exists
     * For real Social Provider
     *
     * @return void
     */
    public function testSocialConfigFails()
    {
        $success_config = SocialConfigDataController::getProviderConfig( 'vk', 'XXX' );

        $this->assertEquals( $success_config, false );
    }
}
