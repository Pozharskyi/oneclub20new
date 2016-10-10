<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 12:53
 */

namespace App\Http\Controllers\Admin\Manage\Brands;

use App\Http\Controllers\Controller;
use App\Models\Basic\BasicBrandsModel;

class AdminManageBrandsValidationController extends Controller
{
    protected function actionValidateIfBrandExists( $brand_name )
    {
        $brand = BasicBrandsModel::where( 'brand_name', $brand_name )
            ->first(['id']);

        if( isset( $brand->id ) )
        {
            return true;
        }

        return false;
    }

}