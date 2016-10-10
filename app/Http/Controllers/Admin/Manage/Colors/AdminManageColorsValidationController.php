<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 12:53
 */

namespace App\Http\Controllers\Admin\Manage\Colors;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductColorModel;

class AdminManageColorsValidationController extends Controller
{
    protected function actionValidateIfColorExists( $color_name )
    {
        $brand = ProductColorModel::where( 'name', $color_name )
            ->first(['id']);

        if( isset( $brand->id ) )
        {
            return true;
        }

        return false;
    }

}