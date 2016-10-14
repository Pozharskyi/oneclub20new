<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminDiscountMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url '/admin/discounts'
     * success access for Маркетинг
     */
    public function testReadDiscountAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', 'Маркетинг')->first();    //get Маркетинг роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/discounts');
        $this->seePageIs(url('/admin/discounts'));
    }

    /**
     * url '/admin/discounts'
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

        $this->call('get', '/admin/discounts');

        $this->seeStatusCode(403);
    }
}
