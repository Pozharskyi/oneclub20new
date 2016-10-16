<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 12:42
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportPartiesTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingParties()
    {
        $partyController = new \App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesController();

        $request = $this->call('POST', '/admin/import/parties/create', [
            'party_name' => 'Any',
            'import_supplier_id' => '1',
            'buyer_id' => '1',
            'support_id' => '1',
            'party_start_date' => '2016-01-10',
            'party_end_date' => '2016-20-10',
            'import_index_categories_id' => '1',
        ]);

        $this->assertEquals('200', $request->status());
        $this->see('alert_status');

        $parties = $partyController->actionGetAllParties();
        $count = count( $parties );

        if($count > 0)
        {
            $this->assertTrue(true);
        } else
        {
            $this->assertTrue(false);
        }
    }

    public function testGettingPartiesAssociation()
    {
        $partyController = new \App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesController();

        $request = $this->call('PUT', '/admin/import/sales/association/confirm', [
            'party_id' => '1',
            'sale_id' => '1',
        ]);

        $this->assertEquals('200', $request->status());

        $association = $partyController->actionValidateSaleExistenceWithParty('1', '1');

        if($association != 0)
        {
            $this->assertTrue(true);
        } else
        {
            $this->assertTrue(false);
        }
    }

}