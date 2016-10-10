<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 21:20
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NPDeliveryPointsTest extends TestCase
{
    /**
     * Testing if getting all cities
     * by NovaPoshta Api
     */
    public function testGettingNPCities()
    {
        $this->visit('/delivery/nova_poshta/cities')
            ->see('<label for="city">');
    }

    /**
     * Failing with getting points
     * by city in NovaPoshta Api
     */
    public function testGettingNPPointsFails()
    {
        $result = false;

        try {
            $this->visit('/delivery/nova_poshta/delivery_points/8e1718f5-1972-11e5-add9')
                ->dontSee('<option>');
        } catch( Exception $e )
        {
            $result = true;
        }

        $this->assertTrue( $result );
    }

    /**
     * Testing if is getting
     * points by city
     */
    public function testGettingNPPoints()
    {
        $this->visit('/delivery/nova_poshta/delivery_points/8e1718f5-1972-11e5-add9-005056887b8d')
            ->see('<option value="4ecddea5-1986-11e5-add9-005056887b8d">');
    }

}