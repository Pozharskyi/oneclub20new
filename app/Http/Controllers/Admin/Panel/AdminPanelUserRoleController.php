<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Models\User\RoleModel;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AdminPanelUserRoleController extends Controller
{
    public function getAssignRoleView($userId)
    {
        $roles = RoleModel::all();
        $user = User::with(['roles'])->findOrFail($userId);
//        var_dump($user->roles->lists('id'));
        return view('admin.panel.user_roles.assign_role')
            ->with('roles', $roles)
            ->with('user', $user);
    }

    public function assignRole(Request $request, $userId)
    {
        $roleIds = $request->input('roleIds');

        $user = User::findOrFail($userId);

        $user->roles()->sync($roleIds);

        Session::flash('message', 'Роли были успешно добавленны пользователю '. $user->name);

        return redirect()->route('adminTable.users.searchUser');
    }
}
