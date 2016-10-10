<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:41
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductColorModel;

/**
 * Main handler for products colors
 * Includes search, creation and
 * Force search
 * Class AdminImportProductColorsTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportProductColorsTrait
{
    /**
     * Finding color by name
     * If no colors found
     * Make Error alert and return bool
     * else return color id
     * @param AdminImportStageController $stage
     * @param $color
     * @return bool
     */
    public function actionFindColorByName( $color, AdminImportStageController $stage = null )
    {
        $object = ProductColorModel::where( 'name', $color )
            ->first(['id']);

        if( !isset( $object->id ) )
        {
            if( !is_null( $stage ) )
            {
                $stage->actionPushStage( 'ERROR', 'Цвет не найден: ' . $color );
            }

            return false;
        } else
        {
            return $object->id;
        }
    }

}