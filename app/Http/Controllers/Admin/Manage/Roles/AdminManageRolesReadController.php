<?php

namespace App\Http\Controllers\Admin\Manage\Roles;

use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\User\RoleModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageRolesReadController extends Controller implements AdminImportReadInterface
{
    //
    /**
     * Getting read method
     * @param Request $request
     * @return mixed
     */
    public function actionRead(Request $request)
    {
        $alert = $request->input( 'alert' );

        if( !isset( $alert ) )
        {
            $alert = false;
        }

        $roles = RoleModel::all();

        return view( 'admin.manage.roles.read', [
            'roles' => $roles,
            'alert' => $alert,
        ]);    }
}
