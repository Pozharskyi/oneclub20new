<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Colors;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Product\ProductColorModel;
use Illuminate\Http\Request;

class AdminManageColorsDeleteController extends Controller implements AdminImportDeleteInterface
{
    public function actionDelete( Request $request )
    {
        $this->authorize('actionDelete', ProductColorModel::first());

        $color_id = $request->input( 'color_id' );
        $result = 'true';

        try
        {
            $color = ProductColorModel::findOrFail( $color_id );
            $color->delete();
        } catch( \Exception $e )
        {
            $result = 'false';
        }

        return $result;
    }

}