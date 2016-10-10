<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 13:36
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShopCatalogDescriptionTest extends TestCase
{
    public function testGettingDescriptionFails()
    {
        $request = $this->call('GET', '/list/1111-1111-1111-1111');

        $this->assertEquals( 500, $request->status() );
    }

    public function testGettingDescription()
    {
        $request = $this->call('GET', '/list/4149-5070-9051-1234');

        $this->assertEquals( 200, $request->status() );
    }

    public function testGettingContent()
    {
        $this->visit('/list/4149-5070-9051-1234')
            ->see('<div class="container" id="content_row">');
    }

}