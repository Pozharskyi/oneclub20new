<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 0:45
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Checkout\CheckoutIndexController;

class CheckoutPaymentTypesTest extends TestCase
{
    public function testGettingPaymentTypes()
    {
        $checkout = new CheckoutIndexController;

        $types = $checkout->actionGetPaymentTypes();

        $this->assertEquals( $types[0]->payment_type, 'Наличными' );
        $this->assertNotContains( 'Yandex', $types );
    }

}