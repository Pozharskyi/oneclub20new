<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 12:20
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class AdminImportSuppliersReadTest extends TestCase
{
    public function testGettingUsers()
    {
        $user = User::find(1);

        $this->actingAs( $user )
            ->visit('/admin/import/suppliers')
            ->see('Supplier test 1')
            ->dontSee('Test test test');
    }

    public function testGettingUsersFail()
    {
        // TODO with auth
        $this->assertTrue( true );
    }

}