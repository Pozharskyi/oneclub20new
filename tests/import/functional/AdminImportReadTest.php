<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:09
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportReadTest extends TestCase
{
    public function testGettingView()
    {
        $user = \App\User::find(1);
        $request = $this->actingAs($user)
            ->call('GET', '/admin/import');

        $this->see('Товарные партии');
        $this->assertEquals(200, $request->status());
    }
}