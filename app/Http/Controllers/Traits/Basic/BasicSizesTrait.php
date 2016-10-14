<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 15:10
 */

namespace App\Http\Controllers\Traits\Basic;

use App\Models\Product\ProductSizeModel;

trait BasicSizesTrait
{
    public final function actionGetSizes()
    {
        $sizesCollection = ProductSizeModel::get(['name']);
        $sizes = array();

        foreach( $sizesCollection as $collection )
        {
            array_push($sizes, $collection->name);
        }

        return $sizes;
    }

}