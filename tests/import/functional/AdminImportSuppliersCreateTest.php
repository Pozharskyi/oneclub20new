<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 14:31
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class AdminImportSuppliersCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreatingSupplier()
    {
        $user = User::find(1);

        $response = $this->actingAs( $user )
            ->call('POST', '/admin/import/suppliers/create', [
                'name' => 'Oleksandr Serdiuk',
                'shop' => 'Oneclub',
                'contact_person' => 'Dmitry Serdiuk',
                'brands' => 'Dirk',
                'phones' => '0950948268',
                'email' => 'serdiuk@goldcoach.ru',
                'coefficient' => '1.25 - 1.5',
                'product_marga' => '25',
                'time_of_returns' => '9 days',
                'work_status' => 'Работаем',
                'work_comment' => 'any',
                'agreement' => 'Есть',
                'start_working' => 'Any',
                'payment_form' => 'N',
                'payment_postpone' => '1-9 days',
                'ecommerce_comment' => 'Any',
                'address_sending' => 'Any',
                'logistic_comment' => 'Any',
                'address_return' => 'Any',
                'products_category' => 'Any',
                'buyer_id' => '1',
            ]);

        $this->seeInDatabase('dev_supplier', [
            'name' => 'Oleksandr Serdiuk',
            'shop' => 'Oneclub',
            'contact_person' => 'Dmitry Serdiuk',
            'brands' => 'Dirk',
            'phones' => '0950948268',
            'email' => 'serdiuk@goldcoach.ru',
        ]);

        $this->assertEquals( 302, $response->status() );
    }

    public function testCreatingSupplierFailByNonAuth()
    {
        $response = $this->call('POST', '/admin/import/suppliers/create', [
            'name' => 'Anyone',
            'shop' => 'Oneclub',
            'contact_person' => 'Dmitry Serdiuk',
            'brands' => 'Dirk',
            'phones' => '0950948268',
        ]);

        $this->notSeeInDatabase('dev_supplier', [
            'name' => 'Anyone',
            'shop' => 'Oneclub',
            'contact_person' => 'Dmitry Serdiuk',
            'brands' => 'Dirk',
            'phones' => '0950948268',
            'made_by' => 1,
        ]);

        $this->assertEquals( 302, $response->status() );
    }

    public function testWatchingNewSupplier()
    {
        $this->visit('/admin/import/suppliers/')
            ->see('Oleksandr Serdiuk')
            ->dontSee('Anyone');
    }

    public function testFormFails()
    {
        $user = User::find(1);

        $this->actingAs( $user )
            ->visit('/admin/import/suppliers/create')
            ->type('Supplier test 1', 'name')
            ->type('Test supplier', 'shop')
            ->press('Добавить поставщика')
            ->seePageIs('/admin/import/suppliers/create');
    }

    public function testFormSucceed()
    {
        $user = User::find(1);

        $this->actingAs( $user )
            ->visit('/admin/import/suppliers/create')
            ->type('New test', 'name')
            ->type('New comment', 'comment')
            ->press('Добавить поставщика')
            ->seePageIs('/admin/import/suppliers')
            ->see('New test');
    }

}