<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 0:58
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Models\Shop\Basket\BasketModel;

class ShopProductsTest extends TestCase
{
    public function testGettingPrice()
    {
        BasketModel::create([
            'user_id' => 1,
            'sub_product_quantity' => 1,
            'sub_product_id' => 1,
        ]);

        $prices = OrderPricesController::actionGetPricesAndQuantityFromBasket( 1 );

        $this->assertNotEquals( 0, $prices->total_price );
        $this->assertNotEquals( 0, $prices->total_quantity );

    }

}