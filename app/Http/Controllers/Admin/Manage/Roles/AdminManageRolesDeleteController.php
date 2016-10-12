<?php

namespace App\Http\Controllers\Admin\Manage\Roles;

use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\User\RoleModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageRolesDeleteController extends Controller implements AdminImportDeleteInterface
{
    //
    /**
     * Handle deletion
     * @param Request $request
     * @return mixed
     */
    public function actionDelete(Request $request)
    {
        $result = 'true';

        $role_id = $request->input('role_id');

        try {
            $role = RoleModel::findOrFail($role_id);

            $this->authorize('actionDelete', $role);

            $role->delete();
        } catch (\Exception $e) {
            $result = 'false';
        }
        return $result;
    }
}
