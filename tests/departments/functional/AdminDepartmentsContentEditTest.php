<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 12:59
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDepartmentsContentEditTest extends \TestCase
{
    const ROUTE = '/admin/departments/content/edit';
    use DatabaseTransactions;

    public function testGettingView()
    {
        $request = $this->call('PUT', self::ROUTE, [
            'subProductId' => '1',
        ]);

        $this->assertEquals('200', $request->status());
    }

    public function testGettingEditView()
    {
        $this->call('PUT', self::ROUTE, [
            'subProductId' => '1',
        ]);

        $this->see('Редактирование')
            ->dontSee('alert');
    }

    public function testGettingErrorEditView()
    {
        $this->call('PUT', self::ROUTE, [
            'subProduct' => '1', // hereby must me subProductId
        ]);

        $this->see('alert')
            ->dontSee('Редактирование');
    }

    public function testGettingUpdateWithFields()
    {
        $fields = [
            'product_name' => 'Test product name',
            'product_description' => 'Test description',
            'product_composition' => 'Test composition',
            'comment_frontend' => 'Test frontend comment',
            'country_manufacturer' => 'Test manufacturer',
            'confirmType' => '8',
            'subProductId' => '1',
            'parentProductId' => '1',
        ];

        $this->call('POST', self::ROUTE, $fields);

        $this->see('success');
    }

}