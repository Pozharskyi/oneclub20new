<?php

namespace App\Http\Controllers\Admin\Manage\Roles;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\User\RoleModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageRolesCreateController extends Controller implements AdminImportCreateInterface
{
    //
    /**
     * Getting create view for UI
     * @param Request $request
     * @return mixed
     */
    public function actionGetCreateView(Request $request)
    {
        $role = RoleModel::first();
        $this->authorize('actionGetCreateView', $role);

        return view('admin.manage.roles.create');
    }

    /**
     * Handling create from
     * create Form
     * @param Request $request
     * @return mixed
     */
    public function actionCreate(Request $request)
    {
        $this->authorize('actionCreate', RoleModel::first());

        $role = new RoleModel($request->all());
        $role->save();

        return redirect('/admin/manage/roles?alert=created');
    }
}
