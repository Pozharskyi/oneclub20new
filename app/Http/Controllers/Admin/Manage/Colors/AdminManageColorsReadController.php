<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:44
 */

namespace App\Http\Controllers\Admin\Manage\Colors;

use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Product\ProductColorModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminManageColorsReadController extends Controller implements AdminImportReadInterface
{
    public function actionRead( Request $request )
    {
        $this->authorize('actionRead', ProductColorModel::first());

        $alert = $request->input( 'alert' );

        if( !isset( $alert ) )
        {
            $alert = false;
        }

        $colors = ProductColorModel::with(['user'])
            ->get();

        return view( 'admin.manage.colors.read', [
            'colors' => $colors,
            'alert' => $alert,
        ]);

    }

}