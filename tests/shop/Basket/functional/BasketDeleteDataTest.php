<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 23:54
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Shop\Basket\BasketModel;

class BasketDeleteDataTest extends TestCase
{
    public function testDeleteDataURIFails()
    {
        $request = $this->call('DELETE', '/list/save/test');

        $this->assertEquals( 404, $request->status() );
    }

    public function testDeleteDataURIBasketIdFails()
    {
        $request = $this->call('DELETE', '/list/save/1001');

        $this->assertNotEquals( 200, $request->status() );
    }

    public function testDeleteData()
    {
        $request = $this->call('DELETE', '/list/save/1');

        $this->assertEquals( 200, $request->status() );
    }

    public function testDeletingFromBasket()
    {
        $this->dontSeeInDatabase('dev_index_basket', [
            'id' => 1,
        ]);
    }

}