<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserInfoMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/users/{user}/orders/{order}
     * success access for Маркетинг
     */
    public function testReadOrderAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', 'СуперАдмин')->first();    //get Маркетинг роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/users/'.$user->id);
        $this->seePageIs(url('/admin/users/'.$user->id));
    }

    /**
     * url /admin/manage/brands
     * failed access for Логист
     */
    public function testReadBrandsAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', 'Логист')->first();    //get Маркетинг роль
        $user->roles()->attach($role);
        $this->be($user);


        $this->call('get', '/admin/users/'.$user->id);

        $this->assertSessionHas('message','Нет прав доступа');
    }
}
