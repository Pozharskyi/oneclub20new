<?php

use App\Models\User\RoleModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleUpdateTest extends TestCase
{
    /**
     * for user with СуперАдмин role should see roleToUpdate info
     * url /admin/manage/roles/update/{role_id}
     */
    public function testActionGetUpdateViewSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);

        $this->be($user);

        $roleToUpdate = RoleModel::where('id', '!=', $role->id)->first();
        $this->call('get', '/admin/manage/roles/update/'.$roleToUpdate->id);
        $this->seeStatusCode(200);
        $this->seeInField('#role_name', $roleToUpdate->name);
    }

    /**
     * for user with NOT СуперАдмин role should see 403 status code exception
     * url /admin/manage/roles/update/{role_id}
     */
    public function testActionGetUpdateViewFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);

        $roleToUpdate = RoleModel::where('id', '!=', $role->id)->first();

        $this->call('get', '/admin/manage/roles/update/'.$roleToUpdate->id);
        $this->seeStatusCode(403);
    }

    /**
     * for user with СуперАдмин role should be able to update role
     * url /admin/manage/roles/update
     */
    public function testActionUpdateSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);

        $this->be($user);
        $roleToUpdate = RoleModel::where('id', '!=', $role->id)->first();

        $params = [
            'role_name' => 'testName',
            'role_description' => 'testDesc',
            'role_id' => $roleToUpdate->id,
        ];

        $this->call('post', '/admin/manage/roles/update', $params);

        $this->seeInDatabase('dev_roles', ['id' => $roleToUpdate->id, 'name' => $params['role_name']]);
        $this->seeStatusCode(302);

    }

    /**
     * for user with NOT СуперАдмин role should see 403 status code
     * url /admin/manage/roles/update
     */
    public function testActionUpdateFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);
        $roleToUpdate = RoleModel::where('id', '!=', $role->id)->first();

        $params = [
            'role_name' => 'testName',
            'role_description' => 'testDesc',
            'role_id' => $roleToUpdate->id,
        ];

        $this->call('post', '/admin/manage/roles/update', $params);
        $this->seeStatusCode(403);

        $this->notSeeInDatabase('dev_roles', ['id' => $roleToUpdate->id, 'name' => $params['role_name']]);

    }
}
