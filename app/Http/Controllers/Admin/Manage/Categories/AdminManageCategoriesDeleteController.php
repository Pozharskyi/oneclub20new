<?php

namespace App\Http\Controllers\Admin\Manage\Categories;

use App\Models\Category\CategoryModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageCategoriesDeleteController extends Controller
{
    public function actionDelete(Request $request)
    {
        $categoryId = $request->input( 'category_id' );
        $result = 'true';
        try
        {
            $category = CategoryModel::findOrFail( $categoryId );
            $category->delete();
        } catch( \Exception $e )
        {
            $result = 'false';
        }

        return $result;
    }
}
