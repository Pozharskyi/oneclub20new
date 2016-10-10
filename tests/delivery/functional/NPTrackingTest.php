<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 21:29
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NPTrackingTest extends TestCase
{
    /**
     * Getting if no TTNs
     * found
     */
    public function testTrackingSucceed()
    {
        $this->visit('/delivery/nova_poshta/tracking/1234')
            ->see('<h1>Not Found</h1>');
    }

}