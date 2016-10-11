<?php

use App\Models\Basic\BasicBrandsModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductSizeModel;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SizeChartCreateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/size_chart/create
     */
    public function testCreateSizeChartSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        //get 3-d level categories
        $categories = CategoryModel::all(['id', 'parent_id']);
        $newCategories = Collection::make();
        foreach ($categories as $category) {
            if (isset($category->parent->parent)) {
                $newCategories->push($category);
            }
        }
        $brand = BasicBrandsModel::first(['id']);
        $size = ProductSizeModel::first(['id']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']); //nameIds

        $parameters = [
            'nameIds' => [$measurementsNames->first()->id, $measurementsNames->last()->id],
            'brand_id' => $brand->id,
            'size_id' => $size->id,
            'category_id' => $newCategories->first()->id,
            'brand_size' => 34,
            'values' => ['45-48'],
        ];

        //set the value according to the last measurement's name
        $parameters['values'][$measurementsNames->count() - 1] = '78-89';

        $this->call('POST', '/admin/manage/size_chart/create', $parameters);

        //should be new sizeChart with new parameters
        $this->seeInDatabase('dev_size_chart',
            [
                'brand_size' => $parameters['brand_size'],
                'brand_id' => $parameters['brand_id'],
                'size_id' => $parameters['size_id'],
                'category_id' => $parameters['category_id'],
                'created_at' => Carbon::now(),
            ]);

        $newSizeChartId = SizeChartModel::where('created_at', Carbon::now())->first(['id']);
        $this->assertNotEmpty($newSizeChartId);


        //should be new measurements for sizeChart with new parameters
        $this->seeInDatabase('dev_measurements',
            [
                'measurements_names_id' => $parameters['nameIds'][0],
                'value' => $parameters['values'][0],
                'size_chart_id' => $newSizeChartId->id,
                'created_at' => Carbon::now(),
            ]);
        $this->seeInDatabase('dev_measurements',
            [
                'measurements_names_id' => $parameters['nameIds'][1],
                'value' => $parameters['values'][$measurementsNames->count() - 1],
                'size_chart_id' => $newSizeChartId->id,
                'created_at' => Carbon::now(),
            ]);

        $this->assertResponseStatus(302);
    }

    public function testCreateSizeChartFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $parameters = [
            'nameIds' => 100,
            'brand_id' => 100,
            'size_id' => 100,
            'category_id' => 100,
            'brand_size' => 34,
            'values' => ['45-48'],
        ];
        $this->call('POST', '/admin/manage/size_chart/create', $parameters);

        //should be NO new sizeChart with new parameters
        $this->notSeeInDatabase('dev_size_chart',
            [
                'brand_size' => $parameters['brand_size'],
                'brand_id' => $parameters['brand_id'],
                'size_id' => $parameters['size_id'],
                'category_id' => $parameters['category_id'],
                'created_at' => Carbon::now(),
            ]);
    }

    /**
     * try to create new sizeChart with invalid  nameIds, should rollback all created fields
     */
    public function testCreateSizeChartFailedAndTransactionRollBack()
    {

        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        //get 3-d level categories
        $categories = CategoryModel::all(['id', 'parent_id']);
        $newCategories = Collection::make();
        foreach ($categories as $category) {
            if (isset($category->parent->parent)) {
                $newCategories->push($category);
            }
        }
        $brand = BasicBrandsModel::first(['id']);
        $size = ProductSizeModel::first(['id']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']); //nameIds

        //all valid except nameIds
        $parameters = [
            'nameIds' => 1000,
            'brand_id' => $brand->id,
            'size_id' => $size->id,
            'category_id' => $newCategories->first()->id,
            'brand_size' => 34,
            'values' => ['45-49'],
        ];
        //set the value according to the last measurement's name
        $parameters['values'][$measurementsNames->count() - 1] = '78-89';

        $this->call('POST', '/admin/manage/size_chart/create', $parameters);

        //should be NO new sizeChart with new parameters
        $this->notSeeInDatabase('dev_size_chart',
            [
                'brand_size' => $parameters['brand_size'],
                'brand_id' => $parameters['brand_id'],
                'size_id' => $parameters['size_id'],
                'category_id' => $parameters['category_id'],
                'created_at' => Carbon::now(),
            ]);
    }
}
