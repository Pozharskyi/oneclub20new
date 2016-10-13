<?php

use App\Models\Category\CategoryModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesUpdateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * url /admin/manage/categories/update/{category_id}
     */
    public function testShowUpdateSucceed()
    {
        //for authentification
        $user = \App\User::find(1);
        $this->be($user);

        $currentCategory = CategoryModel::with(['user', 'parent'])
            ->findOrFail(10);

        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with([
            'parent' => function ($query) {
                $query->get(['id', 'category_name']);
            }
        ])->whereIn('parent_id', $categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        $this->call('GET', url('/admin/manage/categories/update/' . $currentCategory->id));

        $this->see($currentCategory->category_name);

    }

    /**
     * url /admin/manage/categories/update/{category_id} type="POST"
     */
    public function testShowUpdateFailed()
    {
        //for authentification
        $user = \App\User::find(1);
        $this->be($user);

        $this->call('GET', url('/admin/manage/categories/update/' . 100));

        $this->seeStatusCode(404);
    }

    public function testActionUpdateSucceed()
    {
        //for authentification
        $user = \App\User::find(1);
        $this->be($user);

        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with([
            'parent' => function ($query) {
                $query->get(['id', 'category_name']);
            }
        ])->whereIn('parent_id', $categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        $category = $categories->first();

        $params = [
            'category_name' => "Test category name",
            'category_parent_id' => $category->parent_id,
            'category_id' => $category->id,
        ];

        $this->call('post', url('/admin/manage/categories/update'), $params);
        $this->seeStatusCode(302);

        $this->seeInDatabase('dev_index_categories', [
            'id' => $category->id,
            'category_name' => $params['category_name'],
            'parent_id' => $params['category_parent_id'],
        ]);
    }

    //if input parameters not valid should not update category
    public function testActionUpdateFailed()
    {
        //for authentification
        $user = \App\User::find(1);
        $this->be($user);

        //get only two levels from the top
        $categoriesRoot = CategoryModel::where('parent_id', 0)->get(['id']);

        $categories = CategoryModel::with([
            'parent' => function ($query) {
                $query->get(['id', 'category_name']);
            }
        ])->whereIn('parent_id', $categoriesRoot)
            ->orWhere('parent_id', 0)
            ->get(['id', 'category_name', 'parent_id']);

        $category = $categories->first();

        $existedCategory = CategoryModel::find(2);
        $params = [
            'category_name' => $existedCategory->category_name,
            'category_parent_id' => $existedCategory->parent_id,
            'category_id' => $category->id,
        ];

        $this->call('post', url('/admin/manage/categories/update'), $params);

        $this->dontSeeInDatabase('dev_index_categories', ['id' => $category->id, 'category_name' => $params['category_name']]);
    }
}
