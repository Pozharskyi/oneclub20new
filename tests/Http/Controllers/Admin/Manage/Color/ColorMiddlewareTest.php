<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ColorMiddlewareTest extends TestCase
{
    use DatabaseTransactions;

    public function testReadColorAuthSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);
        $this->be($user);

        $this->call('get', '/admin/manage/colors');
        $this->seePageIs(url('/admin/manage/colors'));
    }

    public function testReadColorAuthFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name','Логист')->firstOrFail();
        $user->roles()->attach($role);
        Session::start();

        $this->be($user);

        $this->call('get', '/admin/manage/colors');

        $this->assertSessionHas('message','Нет прав доступа');
    }
}
