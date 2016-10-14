<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/categories
     * success access for CуперАдмин
     */
    public function testReadCategoriesAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/manage/categories');
        $this->seePageIs(url('/admin/manage/categories'));
    }

    /**
     * url /admin/manage/categories
     * failed access for Логист
     */
    public function testReadCategoriesAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name','Логист')->firstOrFail();
        $user->roles()->attach($role);
        Session::start();

        $this->be($user);

        $this->call('get', '/admin/manage/categories');

        $this->seeStatusCode(403);
    }
}
