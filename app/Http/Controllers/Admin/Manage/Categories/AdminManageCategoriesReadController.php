<?php

namespace App\Http\Controllers\Admin\Manage\Categories;

use App\Models\Category\CategoryModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageCategoriesReadController extends Controller
{
    public function actionRead(Request $request)
    {
        $alert = $request->input( 'alert' );

        if( !isset( $alert ) )
        {
            $alert = false;
        }

        $categories = CategoryModel::with(['parent' => function($query){
            $query->get(['id', 'category_name']);
        }])->get();

        return view( 'admin.manage.categories.read', [
            'categories' => $categories,
            'alert' => $alert,
        ]);
    }
}
