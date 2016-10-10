<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 12:56
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Basic\BasicBrandsModel;

/**
 * Main controller based on controlling
 * brands
 * Class AdminImportBrandsTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportBrandsTrait
{
    /**
     * Validating if brand exists
     * If exists return id
     * else return Error message
     * @param AdminImportStageController $stage
     * @param $brandName
     * @return bool
     */
    public function actionValidateBrandExistence(AdminImportStageController $stage, $brandName)
    {
        $brand = BasicBrandsModel::where('brand_name', $brandName)
            ->first(['id']);

        if (isset($brand->id)) {
            return $brand->id;
        } else {
            $stage->actionPushStage('ERROR', "Бренда с названием " . $brandName . " не существует");

            return false;
        }
    }

    /**
     * Updating brand for product
     * If brand exists return id
     * else return Error message
     * @param AdminImportStageController $stage
     * @param $brandName
     * @return bool
     */
    public function actionUpdateBrand(AdminImportStageController $stage, $brandName)
    {
        $brand = BasicBrandsModel::where('brand_name', $brandName)
            ->first(['id']);

        if (isset($brand->id)) {
            return $brand->id;
        } else {
            $stage->actionPushStage('ERROR', "Бренда с названием " . $brandName . " не существует");

            return false;
        }
    }

}