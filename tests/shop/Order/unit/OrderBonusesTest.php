<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 13:41
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\Shop\Order\OrderBonusesController;

class OrderBonusesTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingUserBonuses()
    {
        $bonuses_available = OrderBonusesController::actionValidateUserBonuses( 1, 1 );

        $this->assertNotFalse( $bonuses_available );
    }

    public function testGettingUserBonusesFails()
    {
        $bonuses_available = OrderBonusesController::actionValidateUserBonuses( 101, 101 );

        $this->assertFalse( $bonuses_available );
    }

    public function testUpdatingBonusesFails()
    {
        $result = true;

        try
        {
            OrderBonusesController::actionUpdateBonuses(101, 101);
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testUpdatingBonuses()
    {
        $result = true;

        try
        {
            OrderBonusesController::actionUpdateBonuses(1, 1);
        } catch ( Exception $e )
        {
            $result = false;
        }

        $this->assertTrue( $result );
    }

    public function testInsertingBonusesFails()
    {
        $result = true;

        try
        {
            OrderBonusesController::actionInsertBonuses(101, 1);
        } catch( Exception $e )
        {
             $result = false;
        }

        $this->assertFalse( $result );
    }

    public function testInsertingBonuses()
    {
        $insert = OrderBonusesController::actionInsertBonuses( 1, 1 );

        $this->assertNotFalse( $insert );
    }



}