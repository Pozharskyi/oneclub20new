<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.09.2016
 * Time: 23:23
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class BasketAddingDataTest extends TestCase
{
    /**
     * Testing if not adding to basket
     */
    public function testUserAddingFails()
    {
        $request = $this->call('POST', '/list/save/1');

        $result = true;

        if( !$request->isRedirection() ) {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    /**
     * Testing if products are
     * added to basket
     */
    public function testUserAddingSucceed()
    {
        $user = User::FindOrFail(1);

        $this->actingAs( $user )
            ->call('POST', '/list/save/1', [
                'color' => 1,
                'size' => 1,
                'quantity' => 1,
            ]);

        $this->seeInDatabase('dev_index_basket', [
            'user_id' => 1,
            'sub_product_id' => 1,
        ]);

        $this->assertRedirectedTo('/basket');
    }

    /**
     * Test if quantity updates
     */
    public function testUserUpdatingBasket()
    {
        /*
        $user = User::FindOrFail(1);

        $this->actingAs( $user )
            ->call('POST', '/list/save/1', [
                'color' => 1,
                'size' => 1,
                'quantity' => 1,
            ]);
        */

        // must be don't
        $this->seeInDatabase('dev_index_basket', [
            'user_id' => 1,
            'sub_product_id' => 1,
            'sub_product_quantity' => 1,
        ]);
    }
}