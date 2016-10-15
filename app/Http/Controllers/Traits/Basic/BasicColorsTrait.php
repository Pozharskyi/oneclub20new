<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 14:32
 */

namespace App\Http\Controllers\Traits\Basic;

use App\Models\Product\ProductColorModel;

trait BasicColorsTrait
{
    public final function actionGetColors()
    {
        $colorsCollection = ProductColorModel::get(['name']);
        $colors = array();

        foreach( $colorsCollection as $collection )
        {
            array_push($colors, $collection->name);
        }

        return $colors;
    }

    public final function actionFindColorsWithIds()
    {
        $colorsCollection = ProductColorModel::get(['id','name']);
        $colors = array();

        foreach( $colorsCollection as $collection )
        {
            $colors[$collection->name] = $collection->id;
        }

        return $colors;
    }

}