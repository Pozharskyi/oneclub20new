<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:44
 */

namespace App\Http\Controllers\Admin\Manage\Brands;

use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Basic\BasicBrandsModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminManageBrandsReadController extends Controller implements AdminImportReadInterface
{
    public function actionRead( Request $request )
    {
        $alert = $request->input( 'alert' );

        if( !isset( $alert ) )
        {
            $alert = false;
        }

        $brands = BasicBrandsModel::with(['user'])
            ->get();

        return view( 'admin.manage.brands.read', [
            'brands' => $brands,
            'alert' => $alert,
        ]);

    }

}