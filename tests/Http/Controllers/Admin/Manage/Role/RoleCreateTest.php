<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleCreateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * url /admin/manage/roles type="get"
     */
    public function testGetCreateVew()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);

        $this->be($user);

        $this->call('get', '/admin/manage/roles/create');
        $this->seePageIs(url('/admin/manage/roles/create'));
        $this->seeStatusCode(200);
    }

    /**
     * failed for uses with not СуперАдмин role
     */
    public function testGetCreateViewFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);

        $this->call('get', '/admin/manage/roles/create');

        //Not allowed
        $this->seeStatusCode(403);
    }

    public function testActionCreate()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);

        $this->be($user);

        $params = [
            'name' => 'test Role',
            'description' => 'test desc',
        ];

        $this->call('post', '/admin/manage/roles/create', $params);

        $this->seeInDatabase('dev_roles', ['name' => $params['name'], 'description' => $params['description']]);
        $this->seeStatusCode(302);
    }

    /**
     *  failed for uses with not СуперАдмин role
     */
    public function testActionCreateFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);

        $params = [
            'name' => 'test Role 2',
            'description' => 'test desc 2',
        ];

        $this->call('post', '/admin/manage/roles/create', $params);

        $this->notSeeInDatabase('dev_roles', ['name' => $params['name'], 'description' => $params['description']]);
        $this->seeStatusCode(403);
    }
}
