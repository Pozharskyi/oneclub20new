<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 14:31
 */

namespace App\Http\Controllers\Traits\Basic;

use App\Models\Basic\BasicBrandsModel;

trait BasicBrandsTrait
{
    public final function actionGetBrands()
    {
        $brandsCollection = BasicBrandsModel::get(['brand_name']);
        $brands = array();

        foreach( $brandsCollection as $collection )
        {
            array_push($brands, $collection->brand_name);
        }

        return $brands;
    }

}