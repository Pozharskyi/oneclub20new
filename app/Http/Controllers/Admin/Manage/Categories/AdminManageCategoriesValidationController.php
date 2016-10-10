<?php


namespace App\Http\Controllers\Admin\Manage\Categories;


use App\Models\Category\CategoryModel;

class AdminManageCategoriesValidationController
{
    public static function actionValidateIfCategoryExists( $category_name, $parent_id )
    {
        $category = CategoryModel::where( 'category_name', $category_name )->where('parent_id', $parent_id)
            ->first(['id']);

        if( $category )
        {
            return true;
        }

        return false;
    }
}