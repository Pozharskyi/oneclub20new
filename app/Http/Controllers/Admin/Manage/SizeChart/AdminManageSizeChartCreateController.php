<?php

namespace App\Http\Controllers\Admin\Manage\SizeChart;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Basic\BasicBrandsModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductSizeModel;
use App\Models\SizeChart\MeasurementModel;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class AdminManageSizeChartCreateController extends Controller implements AdminImportCreateInterface
{

    /**
     * Getting create view for UI
     * @param Request $request
     * @return mixed
     */
    public function actionGetCreateView(Request $request)
    {
        //get 3 level categories prepared for view - with all parent level
        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();


        $brands = BasicBrandsModel::all(['id', 'brand_name']);
        $sizes = ProductSizeModel::all(['id', 'name']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']);

        return view('admin.manage.size_chart.create')
            ->with('categories3level', $categories3level)
            ->with('brands', $brands)
            ->with('sizes', $sizes)
            ->with('names', $measurementsNames);
    }

    /**
     * Handling create from
     * create Form
     * @param Request $request
     * @return mixed
     */
    public function actionCreate(Request $request)
    {
        //get id from measurement name table
        $nameIds = $request->input('nameIds');

        //get values for  measurement name
        $values = $request->input('values');

        // begin Transaction
        DB::beginTransaction();
        try {

            $sizeChart = SizeChartModel::create($request->all());

            //save Measurements
            if (!$nameIds) {
                return redirect('/admin/manage/size_chart?alert=created');

            }
            foreach ($nameIds as $nameId) {
                $measurement = new MeasurementModel([
                    'value' => $values[$nameId - 1],             //get value for  measurement name
                    'measurements_names_id' => $nameId,
                ]);
                $measurement->sizeChart()->associate($sizeChart);
                $measurement->save();
            }
            // if succeed do
            DB::commit();
            return redirect('/admin/manage/size_chart?alert=created');

        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();
            return redirect('/admin/manage/size_chart?alert=failed');
        }
    }
}
