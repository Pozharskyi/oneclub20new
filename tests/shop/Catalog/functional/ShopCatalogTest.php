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

use App\Http\Controllers\Shop\Catalog\ShopCatalogIndexController;

class ShopCatalogTest extends TestCase
{
    public function testGettingCatalogColors()
    {
        $catalog = new ShopCatalogIndexController;

        $colors = $catalog->actionGetProductColors();

        $this->assertEquals( 'Green', $colors[0]->name );
        $this->assertNotEquals( 'Test', $colors[0]->name );
    }

    public function testGettingCatalogSizes()
    {
        $catalog = new ShopCatalogIndexController;

        $sizes = $catalog->actionGetProductSizes();

        $this->assertEquals( 'M', $sizes[0]->name );
        $this->assertNotEquals( 'Test', $sizes[0]->name );
    }

    public function testGettingCatalogCategories()
    {
        $catalog = new ShopCatalogIndexController;

        $categories = $catalog->actionGetCategories();

        $this->assertEquals( 'Юбки', $categories[0]->category_name );
        $this->assertNotEquals( 'Test', $categories[0]->category_name );
    }

}