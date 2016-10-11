<?php

use App\Http\Controllers\Admin\Manage\SizeChart\AdminManageSizeChartGetCategoriesHelper;
use App\Models\Category\CategoryModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesCreateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * url /admin/manage/categories/create type="GET"
     * should see categories from 1 and 2 level and don't see categories from 3 level
     */
    public function testGetCreateView()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
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

        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();

        $this->call('GET', '/admin/manage/categories/create');

        foreach ($categories as $category) {
            $this->see($category->category_name);
        }
        foreach ($categories3level as $category) {
            $this->dontSee($category->category_name);
        }
    }

    /**
     * url /admin/manage/categories/create  type="POST"
     * should new categories should be saved in DB
     */
    public function testCreateCategorySucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
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

        $params = [
            'category_name' => 'Test cat',
            'category_parent_id' => $categories->first()->id,
            'made_by' => $user->id,
        ];


        $this->call('POST', '/admin/manage/categories/create', $params);

        $this->seeInDatabase('dev_index_categories', [
            'category_name' => $params['category_name'],
            'parent_id' => $params['category_parent_id'],
            'made_by' => $params['made_by'],
        ]);

        $this->seeStatusCode(302);
    }

    /**
     * url /admin/manage/categories/create  type="POST"
     * should NOT save category in DB if not valid
     */
    public function testCreateCategoryFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();


        $params = [
            'category_name' => 'Test cat',
            'category_parent_id' => $categories3level->first()->id,
            'made_by' => $user->id,
        ];

        $this->call('POST', '/admin/manage/categories/create', $params);

        $this->notSeeInDatabase('dev_index_categories', [
            'category_name' => $params['category_name'],
            'parent_id' => $params['category_parent_id'],
            'made_by' => $params['made_by'],
        ]);

    }
}
