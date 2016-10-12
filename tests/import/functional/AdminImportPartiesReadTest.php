<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 13:53
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportPartiesReadTest extends TestCase
{
    public function testGettingParties()
    {
        $user = \App\User::find(1);
        $request = $this->actingAs($user)
            ->call( 'PUT', '/admin/import/parties/search' );
        $content = $request->content();

        if( strpos( $content, 'найдено' ) !== false )
        {
            $this->see('Результатов не найдено');
        } else
        {
            $this->see('table');
        }

        $this->assertEquals(200, $request->status());
    }

    public function testGettingPartiesWithScope()
    {
        $request = $this->call( 'PUT', '/admin/import/parties/search/2' );
        $content = $request->content();

        if( strpos( $content, 'найдено' ) !== false )
        {
            $this->see('Результатов не найдено');
        } else
        {
            $this->see('table');
        }

        $this->assertEquals(200, $request->status());
    }

}