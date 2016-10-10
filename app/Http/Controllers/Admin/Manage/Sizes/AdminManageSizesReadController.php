<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:44
 */

namespace App\Http\Controllers\Admin\Manage\Sizes;

use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Product\ProductSizeModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminManageSizesReadController extends Controller implements AdminImportReadInterface
{
    public function actionRead( Request $request )
    {
        $alert = $request->input( 'alert' );

        if( !isset( $alert ) )
        {
            $alert = false;
        }

        $sizes = ProductSizeModel::with(['user'])
            ->get();

        return view( 'admin.manage.sizes.read', [
            'sizes' => $sizes,
            'alert' => $alert,
        ]);

    }

}