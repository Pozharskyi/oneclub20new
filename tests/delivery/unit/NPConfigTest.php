<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 21:16
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use LisDev\Delivery\NovaPoshtaApi2;
use App\Http\Controllers\Delivery\Novaposhta\NPConfigController;

class NPConfigTest extends TestCase
{
    /**
     * Testing if config is not
     * returned or is not correct
     */
    public function testNPConfigFail()
    {
        $fail_config = new NovaPoshtaApi2(
            'any',
            'any', // Language of returning data: ru (default) | ua | en
            FALSE, // in error make Exception: FALSE (default) | TRUE
            'any' // request type: curl (defalut) | file_get_content
        );

        $real_config = NPConfigController::actionGetNovaPoshtaConfig();

        $this->assertNotEquals( $real_config, $fail_config );
    }

    /**
     * Testing if config is real
     * and returned
     */
    public function testNPConfig()
    {
        $normal_config = new NovaPoshtaApi2(
            '951c00869b04d8ede92bdfdf63e6f9f8',
            'ru', // Language of returning data: ru (default) | ua | en
            FALSE, // in error make Exception: FALSE (default) | TRUE
            'curl' // request type: curl (defalut) | file_get_content
        );

        $real_config = NPConfigController::actionGetNovaPoshtaConfig();

        $this->assertEquals( $real_config, $normal_config );
    }

}