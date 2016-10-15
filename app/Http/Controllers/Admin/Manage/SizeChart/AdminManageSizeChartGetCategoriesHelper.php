<?php


namespace App\Http\Controllers\Admin\Manage\SizeChart;


use App\Models\Category\CategoryModel;

class AdminManageSizeChartGetCategoriesHelper
{
    public static function get3levelCategoriesWithParents()
    {
        //get all categories
        $categories = CategoryModel::get(['id', 'category_name', 'parent_id']);

        //get first level
        $categories1level = $categories->where('parent_id', 0);
        //get second level
        $categories2level = $categories->whereIn('parent_id', $categories1level->pluck('id')->toArray());
        //get third level
        $categories3level = $categories->whereIn('parent_id', $categories2level->pluck('id')->toArray());

        //prepare 3level category for view (with all level parents)
        foreach ($categories3level as $category)
        {
            $category['parent1'] = $categories2level->where('id', $category->parent_id)->first();
            $category['parent2'] = $categories1level->where('id', $category['parent1']->parent_id)->first();
        }
        return $categories3level;
    }
}