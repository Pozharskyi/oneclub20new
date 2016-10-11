<?php


namespace App\Http\Controllers\Admin\Manage\Categories;


use App\Models\Category\CategoryModel;

class AdminManageCategoriesValidationController
{
    public static function actionValidateIfCategoryExists($category_name, $parent_id)
    {
        $category = CategoryModel::where('category_name', $category_name)->where('parent_id', $parent_id)
            ->first(['id']);


        if ($category) {
            return true;
        }

        return false;
    }

    public static function actionValidateParentCategory($parent_id)
    {
        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with([
            'parent' => function ($query) {
                $query->get(['id', 'category_name']);
            }
        ])->whereIn('parent_id', $categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        $parentCategory = $categories->where('id', $parent_id);
        if ($parentCategory->isEmpty()) {
            return false;
        }

        return true;
    }
}