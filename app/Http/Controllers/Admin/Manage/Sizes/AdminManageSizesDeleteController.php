<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Sizes;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Product\ProductSizeModel;
use Illuminate\Http\Request;

class AdminManageSizesDeleteController extends Controller implements AdminImportDeleteInterface
{
    public function actionDelete( Request $request )
    {
        $size_id = $request->input( 'size_id' );
        $result = 'true';

        try
        {
            $color = ProductSizeModel::findOrFail( $size_id );
            $color->delete();
        } catch( \Exception $e )
        {
            $result = 'false';
        }

        return $result;
    }

}