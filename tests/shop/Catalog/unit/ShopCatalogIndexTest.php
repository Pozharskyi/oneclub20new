<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 13:12
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShopCatalogIndexTest extends TestCase
{
    public function testGettingCatalog()
    {
        $this->visit('/list')
            ->see('<div id="catalog_items">');
    }

    public function testGettingResponse()
    {
        $this->visit('/list')
            ->assertResponseStatus(200);
    }

}