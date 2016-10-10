<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 14:38
 */

namespace App\Http\Controllers\Shop\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryModel;

define( 'PARENT_ID', 0 );

class ShopCatalogCategoriesController extends Controller
{
    public function actionGetCategoriesTree()
    {
        $result = array();
        $categories = CategoryModel::orderBy( 'parent_id' )
            ->get();

        foreach( $categories as $category )
        {
            $result[$category->parent_id][] = [
                'id' => $category->id,
                'category_name' => $category->category_name,
                'parent_id' => $category->parent_id,
            ];
        }

        return $result;
    }

}