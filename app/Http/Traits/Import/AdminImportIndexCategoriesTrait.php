<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:49
 */

namespace App\Http\Controllers\Traits\Import;


use App\Models\Import\ImportIndexCategoriesModel;

trait AdminImportIndexCategoriesTrait
{
    public function actionGetImportCategories()
    {
        $categories = ImportIndexCategoriesModel::get([
            'id', 'name'
        ]);

        return $categories;
    }

}