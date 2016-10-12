<?php

namespace App\Policies;

use App\Models\User\RoleModel;
use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('СуперАдмин')) {
            return true;
        }
    }

    public function actionGetCreateView(User $user, RoleModel $role)
    {
        return false;
    }

    public function actionCreate(User $user, RoleModel $role)
    {
        return false;
    }

    public function actionGetUpdateView(User $user, RoleModel $role)
    {
        return false;
    }

    public function actionDelete(User $user, RoleModel $role)
    {
        return false;
    }

    public function actionRead(User $user, RoleModel $role)
    {
        return false;
    }

    public function actionUpdate(User $user, RoleModel $role)
    {
        return false;
    }

    public function getUsers(User $user, RoleModel $role)
    {
        return false;
    }

}
