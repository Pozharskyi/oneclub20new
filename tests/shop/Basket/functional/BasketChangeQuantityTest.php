<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 23:41
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BasketChangeQuantityTest extends TestCase
{
    public function testChangeQuantityURIFails()
    {
        $request = $this->call('POST', '/list/change/test', [
            'quantity' => 1,
        ]);

        $this->assertNotEquals( 200, $request->status() );
    }

    public function testChangeQuantityFails()
    {
        $request = $this->call('POST', '/list/change/test', [
            'quantity' => 2,
        ]);

        $this->assertNotEquals( 200, $request->status() );
    }

    public function testChangeQuantitySucceed()
    {
        DB::table('dev_index_basket')->insert([
            'id' => 1,
            'user_id' => 1,
            'sub_product_id' => 1,
            'sub_product_quantity' => 1,
        ]);

        $request = $this->call('POST', '/list/change/1', [
            'quantity' => 1,
        ]);

        $this->assertEquals( 200, $request->status() );
    }

}