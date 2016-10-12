<?php

namespace App\Http\Controllers\Admin\Manage\Roles;

use App\Models\User\RoleModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageRolesUsersController extends Controller
{
    public function getUsers(Request $request, $roleId)
    {
        $users = User::filterByRoleId($roleId)->get();

        $role = RoleModel::findOrFail($roleId);

        return view('admin.manage.roles.users')
            ->with('users', $users)
            ->with('role', $role);
    }
}
