<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserOrderControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserOrderAll()
    {
        $auth = User::find(3);

        $this->be($auth);

        $this->visit('/cabinet/orders')
            ->assertResponseStatus(200)
            ->see('Дата оформления')
            ->see('Z204-3992-0903-0394')
            ->click('Z204-3992-0903-0394')
            ->seePageIs('/cabinet/orders/3');
    }

    public function testUserOrderOne(){
        $auth = User::find(3);

        $this->be($auth);

        $this->visit('/cabinet/orders/5')
            ->assertResponseStatus(200)
            ->see('Заказ Z204-6192-3013-9524');
    }
}
