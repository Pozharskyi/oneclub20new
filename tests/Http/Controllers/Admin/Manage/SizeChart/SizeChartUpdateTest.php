<?php

use App\Http\Controllers\Admin\Manage\SizeChart\AdminManageSizeChartGetCategoriesHelper;
use App\Models\Basic\BasicBrandsModel;
use App\Models\Product\ProductSizeModel;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SizeChartUpdateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/size_chart/update/{size_chart}
     */
    public function testShowUpdateSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $sizeChart = SizeChartModel::with(['brand', 'category', 'size', 'measurements.name'])
            ->first();

        //get 3 level categories prepared for view - with all parent level
        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();


        $brands = BasicBrandsModel::all(['id', 'brand_name']);
        $sizes = ProductSizeModel::all(['id', 'name']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']);

        $params = [
            'brands' => $brands,
            'sizes' => $sizes,
            'sizeChart' => $sizeChart,
            'categories' => $categories3level,
            'measurementsNames' => $measurementsNames,
        ];

        $this->call('GET', '/admin/manage/size_chart/update/' . $sizeChart->id, $params);
        foreach ($brands as $brand) {
            $this->see($brand->brand_name);
        }
        foreach ($categories3level as $category) {
            $this->see($category->category_name);
        }
        foreach ($sizes as $size) {
            $this->see($size->name);
        }
        $this->seeIsSelected('size_id', $sizeChart->size->id);
        $this->seeIsSelected('category_id', $sizeChart->category->id);
        $this->seeIsSelected('brand_id', $sizeChart->brand->id);
        $this->seeInField('#brand_size', $sizeChart->brand_size);
        foreach($sizeChart->measurements as $measurement){
//            $this->seeIsChecked('nameIds[]', $measurement->measurements_names_id);
            $this->seeInField('values-'.$measurement->measurements_names_id, $measurement->value);
        }

        $this->assertResponseOk();
    }

    public function testShowUpdateFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $sizeChart = SizeChartModel::with(['brand', 'category', 'size', 'measurements.name'])
            ->first();

        //get 3 level categories prepared for view - with all parent level
        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();


        $brands = BasicBrandsModel::all(['id', 'brand_name']);
        $sizes = ProductSizeModel::all(['id', 'name']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']);

        $params = [
            'brands' => $brands,
            'sizes' => $sizes,
            'sizeChart' => $sizeChart,
            'categories' => $categories3level,
            'measurementsNames' => $measurementsNames,
        ];

        $this->call('GET', '/admin/manage/size_chart/update/' . 1000, $params);
        $this->seeStatusCode(404);
    }
}
