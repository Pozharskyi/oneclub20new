<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SizeChartMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/size_chart
     * success access for CуперАдмин
     */
    public function testReadSizeChartsAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/manage/size_chart');
        $this->seePageIs(url('/admin/manage/size_chart'));
    }

    /**
     * url /admin/manage/size_chart
     * failed access for Логист
     */
    public function testReadSizeChartsAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name','Логист')->firstOrFail();
        $user->roles()->attach($role);
        Session::start();

        $this->be($user);

        $this->call('get', '/admin/manage/size_chart');

        $this->seeStatusCode(403);
    }
}
