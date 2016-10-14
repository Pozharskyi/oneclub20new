<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrandMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/brands
     * success access for CуперАдмин
     */
    public function testReadBrandsAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/manage/brands');
        $this->seePageIs(url('/admin/manage/brands'));
    }

    /**
     * url /admin/manage/brands
     * failed access for Логист
     */
    public function testReadBrandsAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name','Логист')->firstOrFail();
        $user->roles()->attach($role);
        Session::start();

        $this->be($user);

        $this->call('get', '/admin/manage/brands');

        $this->seeStatusCode(403);
    }
}
