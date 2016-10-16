<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 12:49
 */

namespace App\Http\Controllers\Traits\Product;

use App\Models\Category\CategoryModel;

trait ProductCategoriesTrait
{
    public function actionGetProductCategories()
    {
        $categories4level = $this->actionGetProductLastCategories();
        $categoriesLastLevel = array();

        foreach ( $categories4level as $category )
        {
            array_push( $categoriesLastLevel, $category->category_name );
        }

        return $categoriesLastLevel;
    }

    public function actionGetProductCategoriesWithIds()
    {
        $categories4level = $this->actionGetProductLastCategories();
        $categoriesLastLevel = array();

        foreach ( $categories4level as $category )
        {
            $categoriesLastLevel[$category->category_name] = $category->id;
        }

        return $categoriesLastLevel;
    }

    private function actionGetProductLastCategories()
    {
        //get all categories
        $categories = CategoryModel::get(['id', 'category_name', 'parent_id']);

        //get first level
        $categories1level = $categories->where('parent_id', 0);

        //get second level
        $categories2level = $categories->whereIn('parent_id', $categories1level->pluck('id')->toArray());

        //get third level
        $categories3level = $categories->whereIn('parent_id', $categories2level->pluck('id')->toArray());

        //get fourth level
        $categories4level = $categories->whereIn('parent_id', $categories3level->pluck('id')->toArray());

        return $categories4level;
    }

    public function actionGetAllCategories()
    {
        $categories = CategoryModel::get();

        return $categories;
    }

    public function actionSearchLastCategory( $category )
    {
        $lastCategory = CategoryModel::searchLastCategory( $category )
            ->first(['id']);

        return $lastCategory->id;
    }

    public function actionFindCategoryTreeByLast( $category )
    {
        $lastCategory = CategoryModel::searchLastCategory( $category )
            ->first(['id']);

        $categoryId = $lastCategory->id;

        $categories = $this->actionGetAllCategories();

        $result = array();

        foreach( $categories as $category )
        {
            $result[$category->id] = array(
                'name' => $category->category_name,
                'parent_id' => $category->parent_id,
            );
        }

        $categoryResult = array();

        while (true)
        {
            $cat = $result[$categoryId];
            array_push($categoryResult, $cat);

            $categoryId = $result[$categoryId]['parent_id'];

            if($categoryId == 0)
            {
                break;
            }
        }

        return array_reverse($categoryResult);
    }
}