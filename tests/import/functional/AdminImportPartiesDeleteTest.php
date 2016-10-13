<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 13:02
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminImportPartiesDeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function testGettingDeleteView()
    {
        $user = \App\User::find(1);
        $request = $this->actingAs($user)->call('PUT', '/admin/import/parties/delete', [
            'party_id' => '1',
        ]);

        $this->assertEquals('200', $request->status());
    }

    public function testGettingDeleteSucceed()
    {
        $user = \App\User::find(1);

        $request = $this->actingAs($user)->call('DELETE', '/admin/import/parties/delete', [
            'import_index_party_id' => '1',
            'comment' => 'Any',
        ]);

        $this->assertEquals('200', $request->status());
        $this->see('Заявка на удаление была подана.');
    }

    public function testGettingDeleteFailed()
    {
        $request = $this->call('DELETE', '/admin/import/parties/delete', [
            'import_index_party_id' => '1',
            'comment' => 'Any',
        ]);

        $this->assertEquals('200', $request->status());
        $this->see('Что-то пошло не так. Попробуйте чуть позже.');
    }
}