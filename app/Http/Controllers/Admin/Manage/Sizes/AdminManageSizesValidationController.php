<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 12:53
 */

namespace App\Http\Controllers\Admin\Manage\Sizes;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductSizeModel;

class AdminManageSizesValidationController extends Controller
{
    protected function actionValidateIfSizeExists( $size_name )
    {
        $size = ProductSizeModel::where( 'name', $size_name )
            ->first(['id']);

        if( isset( $size->id ) )
        {
            return true;
        }

        return false;
    }

}