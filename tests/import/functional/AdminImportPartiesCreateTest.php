<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 12:54
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportPartiesCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingCreationView()
    {
        $request = $this->call('PUT', '/admin/import/parties/create');

        $this->assertEquals('200', $request->status());
        $this->see('form');
    }

    public function testGettingCreationFailed()
    {
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
        $this->see('Что-то пошло не так. Попробуйте чуть позже.');
    }

    public function testGettingCreationSucceed()
    {
        $user = \App\User::find(1);

        $request = $this->actingAs($user)->call('POST', '/admin/import/parties/create', [
            'party_name' => 'Any',
            'import_supplier_id' => '1',
            'buyer_id' => '1',
            'support_id' => '1',
            'party_start_date' => '2016-01-10',
            'party_end_date' => '2016-20-10',
            'import_index_categories_id' => '1',
            'made_by' => '1',
            'party_days_count' => '19',
            'import_parties_status_id' => '1',
        ]);

        $this->assertEquals('200', $request->status());
        $this->see('Вы успешно создали товарную партию');
    }

}