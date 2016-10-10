<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 16:50
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportSuppliersFindTest extends TestCase
{
    public function testFindDataFails()
    {
        $request = $this->call('PUT', '/admin/import/suppliers/find', [
            'search' => 'xxxxxx',
        ]);

        $this->assertEquals( 200, $request->status() );
        $this->see('Результатов не найдено');
    }

    public function testFindDataSucceed()
    {
        $request = $this->call('PUT', '/admin/import/suppliers/find', [
            'search' => '',
        ]);

        $this->assertEquals( 200, $request->status() );
        $this->dontSee('Результатов не найдено');
    }
}