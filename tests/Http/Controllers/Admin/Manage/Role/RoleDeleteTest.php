<?php

use App\Models\User\RoleModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleDeleteTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * succeed delete role for СуперАдмин
     */
  public function testActionDeleteSucceed()
  {
      //for authentification
      $user = factory(\App\User::class)->create();
      $role = RoleModel::first();    //get СуперАдмин роль
      $user->roles()->attach($role);

      $this->be($user);

      $roleToDelete = RoleModel::where('id', '!=', $role->id)->first();
      $params = [
        'role_id' => $roleToDelete->id,
      ];

      $this->call('delete', url('/admin/manage/roles/delete'), $params);

      $this->seeStatusCode(200);

      $this->seeInDatabase('dev_roles', ['id' => $roleToDelete->id, 'deleted_at' => \Carbon\Carbon::now()]);
  }

    /**
     *
     *  failed for uses with not СуперАдмин role
     */
    public function testActionDeleteFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::where('name', '!=',
            'СуперАдмин')->first();    //get role that is not СуперАдмин
        $user->roles()->attach($role);

        $this->be($user);

        $roleToDelete = RoleModel::where('id', '!=', $role->id)->first();
        $params = [
            'role_id' => $roleToDelete->id,
        ];

        $this->call('delete', url('/admin/manage/roles/delete'), $params);

        $this->seeStatusCode(200);

        $this->seeInDatabase('dev_roles', ['id' => $roleToDelete->id, 'deleted_at' => Null]);
    }
}
