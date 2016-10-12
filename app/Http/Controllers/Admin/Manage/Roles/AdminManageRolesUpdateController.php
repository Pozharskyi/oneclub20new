<?php

namespace App\Http\Controllers\Admin\Manage\Roles;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\User\RoleModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageRolesUpdateController extends Controller implements AdminImportUpdateInterface
{
    public function actionGetUpdateView($role_id)
    {
        $role = RoleModel::findOrFail($role_id);

        $this->authorize('actionGetUpdateView', \Auth::user(),$role);

        return view('admin.manage.roles.update', [
            'role' => $role,
        ]);
    }

    /**
     * Getting update methodc
     * @param Request $request
     * @return mixed
     */
    public function actionUpdate(Request $request)
    {
        $this->authorize('actionUpdate', RoleModel::first());

        $role_name = $request->input('role_name');
        $role_id = $request->input('role_id');
        $role_description = $request->input('role_description');

        try {
            $role = RoleModel::findOrFail($role_id);
            $role->name = $role_name;
            $role->description = $role_description;

            $role->update();

            return redirect('/admin/manage/roles?alert=success');
        } catch (\Exception $e) {

            return redirect('/admin/manage/roles?alert=failed');
        }

    }
}
