<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:43
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDepartmentsContentTest extends \TestCase
{
    const ROUTE = '/admin/departments/content';

    public function testGettingNonExistsRoute()
    {
        $request = $this->call('POST', self::ROUTE);

        $this->assertEquals('405', $request->status());
    }

    public function testGettingView()
    {
        $request = $this->call('GET', self::ROUTE);

        $this->visit('/admin/departments/content')
            ->see('контентом')
            ->dontSee('фото');

        $this->assertEquals('200', $request->status());
    }

}