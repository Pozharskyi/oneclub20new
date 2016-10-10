<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:22
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductDescriptionModel;

/**
 * Handing creating and updating description
 * for the parent product
 * with Warning messages
 * Class AdminImportDescriptionTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportDescriptionTrait
{
    /**
     * If product is found
     * push alert that product found
     * else create new description
     * for the new product
     * @param AdminImportStageController $stage
     * @param $found
     * @param $descriptionArray
     */
    public function actionHandleDescription(AdminImportStageController $stage, $found, $descriptionArray)
    {
        if ($found == 0) {
            $this->actionInsertDescription($stage, $descriptionArray);
        } else {
            $stage->actionPushStage('WARNING', 'Описание продукта уже существует');
        }
    }

    /**
     * Handler for inserting product description
     * Trying to make description based on product id
     * if product is added return any
     * else make Error alert
     * @param AdminImportStageController $stage
     * @param $descriptionArray
     */
    private function actionInsertDescription(AdminImportStageController $stage, $descriptionArray)
    {
        try {
            ProductDescriptionModel::create($descriptionArray);
        } catch (\Exception $e) {
            $stage->actionNotForcePush('ERROR', 'Проблема с добавлением описания для сложенного товара.');
        }
    }

    /**
     * Updating product description
     * based on product id
     * if update array is empty
     * just skip updating
     * @param $productId
     * @param $description
     */
    public function actionUpdateDescription($productId, $description)
    {
        $updateArray = array();

        foreach ($description as $row => $data) {
            if ($data != '') {
                $updateArray[$row] = $data;
            }
        }

        if (!empty($updateArray)) {
            ProductDescriptionModel::where('product_id', $productId)
                ->update($updateArray);
        }
    }
}