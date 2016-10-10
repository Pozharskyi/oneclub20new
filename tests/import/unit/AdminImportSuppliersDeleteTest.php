<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 16:05
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Supplier\SupplierModel;

class AdminImportSuppliersDeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeletingSupplierSucceed()
    {
        $array = [
            'name' => 'Oleksandr',
            'comment' => 'Test',
            'made_by' => 1,
        ];

        SupplierModel::create(
            $array
        );

        $this->seeInDatabase('dev_supplier',
            $array
        );

        $request = $this->call('DELETE', '/admin/import/suppliers/delete', [
            'supplier_id' => 1,
        ]);

        $this->assertEquals( 200, $request->status() );

        $this->seeInDatabase('dev_supplier', [
            'id' => 1,
        ]);
    }

    public function testDeletingSupplierFails()
    {
        $request = $this->call('DELETE', '/admin/import/suppliers/delete', [
            'supplier_id' => 1001,
        ]);

        $this->assertEquals( 404, $request->status() );
    }
}