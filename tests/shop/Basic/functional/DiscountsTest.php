<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 23:07
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DiscountsTest extends TestCase
{
    /**
     * Testing if no discounts failed
     * by incorrect discount id
     */
    public function testDiscountFindFail()
    {
        $response = $this->call('PUT', '/list/discounts/test');

        $this->assertEquals(404, $response->status());
    }

    /**
     * Testing if discount found
     * by correct discount id
     */
    public function testDiscountFindSucceed()
    {
        $response = $this->call('PUT', '/list/discounts/1');

        $this->assertEquals(200, $response->status());
    }

    /**
     * Testing if discount found and return
     * any percent
     */
    public function testDiscountFindSucceedAndReturnsPercent()
    {
        $response = $this->call('PUT', '/list/discounts/1');

        $this->see('25', $response->content());
    }

    /**
     * Testing if discount not found
     * and returns no data
     */
    public function testDiscountNotFound()
    {
        $response = $this->call('PUT', '/list/discounts/101');

        $this->see('Coupon not found', $response->content());
    }

    /**
     * Testing if discount used
     */
    public function testDiscountIsUsed()
    {
        $response = $this->call('PUT', '/list/discounts/2');

        $this->see('Coupon already used', $response->content());
    }

}