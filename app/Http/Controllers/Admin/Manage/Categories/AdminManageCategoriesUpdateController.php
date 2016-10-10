<?php

namespace App\Http\Controllers\Admin\Manage\Categories;

use App\Models\Category\CategoryModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageCategoriesUpdateController extends Controller
{
    public function actionGetUpdateView($category_id)
    {
        $currentCategory = CategoryModel::with(['user', 'parent'])
            ->findOrFail( $category_id );

        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with(['parent' => function($query){
            $query->get(['id', 'category_name']);
        }])->whereIn('parent_id',$categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        return view( 'admin.manage.categories.update', compact('currentCategory', 'categories'));
    }

    public function actionUpdate( Request $request )
    {
        $user_id = \Auth::id();
        $category_name = $request->input( 'category_name' );
        $category_parent_id = $request->category_parent_id;
        $category_id = $request->input( 'category_id' );


        $existence = AdminManageCategoriesValidationController::actionValidateIfCategoryExists( $category_name, $category_parent_id );

        if( $existence === false )
        {
            try
            {
                $category = CategoryModel::findOrFail( $category_id );
                $category->category_name = $category_name;
                $category->parent_id = $category_parent_id;
                $category->made_by = $user_id;

                $category->save();

                return redirect( '/admin/manage/categories?alert=success' );
            } catch( \Exception $e )
            {
                return redirect( '/admin/manage/categories?alert=failed' );
            }
        } else
        {
            return redirect( '/admin/manage/categories?alert=category_exists' );
        }
    }
}
