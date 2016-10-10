<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Auth\Social\SocialLinksAdapterController;

class SocialLinksAdapterTest extends TestCase
{
    /**
     * Test for link about
     * Social Adapter
     * @successful
     *
     * @return void
     */
    public function testLinkAdapterSucceed()
    {
        $social_link = SocialLinksAdapterController::getConfigForSocial( 'facebook' );

        $this->assertNotFalse( $social_link );
    }

    /**
     * Test for link about
     * Social Adapter
     * @wrong Request
     *
     * @return void
     */
    public function testLinkAdapterFails()
    {
        $social_link = SocialLinksAdapterController::getConfigForSocial( 'vk' );

        $this->assertFalse( $social_link );
    }
}
