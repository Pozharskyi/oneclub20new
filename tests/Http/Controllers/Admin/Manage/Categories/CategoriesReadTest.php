<?php

use App\Models\Category\CategoryModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesReadTest extends TestCase
{
    /**
     * url /admin/manage/categories type="GET"
     * should see categories info, link "Редактировать" if it's not top level category
     */
    public function testCategoriesRead()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $categories = CategoryModel::with([
            'parent' => function ($query) {
                $query->get(['id', 'category_name']);
            }
        ])->get();

        $this->call('GET', '/admin/manage/categories');

        foreach ($categories as $category) {
            $this->see($category->user->name);
            $this->see($category->created_at);
            $this->see($category->updated_at);

            if (!$category->parent_id == 0) {
                $this->seeLink('Редактировать', url('/admin/manage/categories/update/' . $category->id));
            } else {
                $this->dontSeeLink('Редактировать', url('/admin/manage/categories/update/' . $category->id));
            }
        }
    }
}
