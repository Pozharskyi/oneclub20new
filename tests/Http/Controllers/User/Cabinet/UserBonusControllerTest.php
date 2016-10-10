<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\User\Cabinet\UserBonusController;
use App\User;

class UserBonusControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserBonusControllerUnit()
    {
        $auth = User::find(1);

        $this->be($auth);

        $bonus = new UserBonusController;

        $responseBonus = $bonus->getUserBonuses();

        $this->assertEquals($responseBonus[0]['bonuses_amount'], '19750.00');
        $this->assertNotEquals($responseBonus[0]['bonuses_amount'], '1000');

        $responseBonusLog = $bonus->getUserBonusesLog();

        $this->assertEquals($responseBonusLog[0]['amount'], '1000.00');
        $this->assertNotEquals($responseBonusLog[0]['amount'], '4500.00');
        $this->assertEquals($responseBonusLog[0]['bonus_type_id'], '1');
        $this->assertNotEquals($responseBonusLog[0]['bonus_type_id'], '4');

        /*
        $responseDiscount = $bonus->getUserDiscounts();
        $responseDiscountLog = $bonus->getUserDiscountsLog();
        */
    }

    public function testUserBonusFuncTest(){
        $auth = User::find(3);

        $this->be($auth);

        $this->visit('/cabinet/bonus')
            ->assertResponseStatus(200)
            ->see('Бонус регистрации')
            ->see('19750');
    }
}
