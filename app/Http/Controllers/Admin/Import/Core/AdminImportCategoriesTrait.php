<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 13:01
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Category\CategoryModel;
use App\Models\Import\ImportPartiesCategoriesModel;

/**
 * Main package controller
 * for product categories
 * Class AdminImportCategoriesTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportCategoriesTrait
{
    /**
     * Handling product category
     * if One of categories is not set
     * get Error message
     * else Get recursive last category
     * @param AdminImportStageController $stage
     * @param $cat1
     * @param $cat2
     * @param $cat3
     * @return bool|int
     */
    public function actionHandleCategories(AdminImportStageController $stage, $cat1, $cat2, $cat3)
    {
        $categories = array(
            1 => $cat1,
            2 => $cat2,
            3 => $cat3,
        );

        $priority = 0;

        foreach ($categories as $list => $category) {
            if ($category == '') {
                $stage->actionPushStage('ERROR', 'Все категории должны быть заполнены. Не заполнена: ' . $category);
            }

            $id = $this->actionSearchCategory($stage, $category, $priority);
            $priority = $id;
        }

        return $priority;
    }

    /**
     * Searching category
     * if Category exists return id
     * else return Error message
     * @param AdminImportStageController $stage
     * @param $categoryName
     * @param $priorityLevel
     * @return bool
     */
    private function actionSearchCategory(AdminImportStageController $stage, $categoryName, $priorityLevel)
    {
        $category = CategoryModel::search($categoryName, $priorityLevel)
            ->first(['id']);

        if (isset($category->id)) {
            return $category->id;
        } else {
            $stage->actionPushStage('ERROR', 'Категория товара не найдена: ' . $categoryName);

            return false;
        }
    }

    /**
     * Getting categories info
     * @return mixed
     */
    protected function actionGetCategories()
    {
        $categories = ImportPartiesCategoriesModel::get();

        return $categories;
    }
}