<?php

use App\Models\User\RoleModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleReadTest extends TestCase
{
    /**
     * for user with СуперАдмин role
     * url /admin/manage/roles type="get" should see all roles in page
     */
   public function testActionReadSucceed()
   {
       //for authentification
       $user = factory(\App\User::class)->create();
       $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
       $user->roles()->attach($role);

       $this->be($user);

       $roles = RoleModel::all();
       $this->call('get', '/admin/manage/roles');

       $this->seePageIs(url('/admin/manage/roles'));

       foreach($roles as $role){
           $this->see($role->name);
       }
   }

    /**
     * for user with СуперАдмин role
     * url /admin/manage/roles type="get" should see all roles in page
     */
    public function testActionReadFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);

        $roles = RoleModel::all();
        $this->call('get', '/admin/manage/roles');

        $this->seeStatusCode(403);
    }
}
