<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.10.2016
 * Time: 0:29
 */

namespace App\Http\Controllers\Traits\Basic;

use App\Models\Basic\BasicGenderModel;

trait BasicGenderTrait
{
    public final function actionFindGender( $gender )
    {
        $gender = BasicGenderModel::where('name', $gender)
            ->first(['id']);

        return $gender->id;
    }

}