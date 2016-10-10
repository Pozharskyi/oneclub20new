<?php

namespace App\Http\Controllers\Admin\Manage\Categories;

use App\Models\Category\CategoryModel;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageCategoriesCreateController extends Controller
{
    public function actionGetCreateView()
    {
        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with(['parent' => function($query){
            $query->get(['id', 'category_name']);
        }])->whereIn('parent_id',$categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        return view( 'admin.manage.categories.create' , compact('categories'));
    }

    public function actionStore(Request $request)
    {
        $user_id = Auth::id();
        $category_name = $request->input( 'category_name' );
        $category_parent_id = $request->category_parent_id;

        $existence = AdminManageCategoriesValidationController::actionValidateIfCategoryExists( $category_name,  $category_parent_id);

        if( $existence === false )
        {
            try
            {
                CategoryModel::create([
                    'category_name' => $category_name,
                    'parent_id' => $category_parent_id,
                    'made_by' => $user_id
                ]);

                return redirect('/admin/manage/categories?alert=created');

            } catch (\Exception $e)
            {
                return redirect('/admin/manage/categories?alert=failed');
            }
        } else
        {
            return redirect( '/admin/manage/categories?alert=category_exists' );
        }
    }
}
