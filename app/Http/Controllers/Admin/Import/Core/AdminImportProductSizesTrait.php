<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:41
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductSizeModel;

/**
 * Main handler for product sizes
 * With logging method of stages
 * Class AdminImportProductSizesTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportProductSizesTrait
{
    public function actionFindSizeByName( $size, AdminImportStageController $stage = null )
    {
        $object = ProductSizeModel::where( 'name', $size )
            ->first(['id']);

        if( !isset( $object->id ) )
        {
            if( !is_null( $stage ) )
            {
                $stage->actionPushStage( 'ERROR', 'Размер не найден: ' . $size );
            }

            return false;
        } else
        {
            return $object->id;
        }
    }

}