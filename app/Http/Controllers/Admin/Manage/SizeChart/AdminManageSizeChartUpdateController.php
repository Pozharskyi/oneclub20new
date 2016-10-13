<?php

namespace App\Http\Controllers\Admin\Manage\SizeChart;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\Basic\BasicBrandsModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductSizeModel;
use App\Models\SizeChart\MeasurementModel;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageSizeChartUpdateController extends Controller implements AdminImportUpdateInterface
{

    public function actionGetUpdateView($size_chart_id)
    {
        $sizeChart = SizeChartModel::with(['brand', 'category', 'size', 'measurements.name'])
            ->findOrFail($size_chart_id);

        //get 3 level categories prepared for view - with all parent level
        $categories3level = AdminManageSizeChartGetCategoriesHelper::get3levelCategoriesWithParents();


        $brands = BasicBrandsModel::all(['id', 'brand_name']);
        $sizes = ProductSizeModel::all(['id', 'name']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']);

        return view('admin.manage.size_chart.update', compact('sizeChart', 'brands', 'sizes', 'measurementsNames'))
            ->with('categories', $categories3level);
    }

    /**
     * Getting update method
     * @param Request $request
     * @return mixed
     */
    public function actionUpdate(Request $request)
    {
        // begin Transaction
        DB::beginTransaction();
        try {
            $sizeChart = SizeChartModel::findOrFail($request->size_chart_id);
            $sizeChart->update($request->all());

            //get id from measurement name table
            $nameIds = $request->input('nameIds');

            //get values for  measurement name
            $values = $request->input('values');
            //get oldMeasurements from old sizeChart
            $measurements = $sizeChart->measurements()->get();
//            dd($nameIds);
//            dd(in_array(2, $measurements->pluck('measurements_names_id')->toArray()));
            //save Measurements
            foreach ($nameIds as $nameId) {
                //update existed measurements
                if (in_array($nameId, $measurements->pluck('measurements_names_id')->toArray())) {
                    //get old measurements by $nameId and update
                    $measurement = $measurements->whereLoose('measurements_names_id', $nameId)->first();

                    $measurement->update(
                        [
                            'value' => $values[$nameId - 1],             //get value for  measurement name
                            'measurements_names_id' => $nameId,
                        ]);
                    //if new name added - create new measurements
                } else {
                    $measurement = new MeasurementModel([
                        'value' => $values[$nameId - 1],             //get value for  measurement name
                        'measurements_names_id' => $nameId,
                    ]);
                    $measurement->sizeChart()->associate($sizeChart);
                    $measurement->save();

                }

            }
            //if removed existed
            foreach ($measurements->pluck('measurements_names_id') as $existedNameId) {
                if (!in_array($existedNameId, $nameIds)) {
                    $measurement = $measurements->whereLoose('measurements_names_id', $existedNameId)->first();
                    $measurement->delete();
                }
            }
            // if succeed do
            DB::commit();
            return redirect('/admin/manage/size_chart?alert=success');

        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();

            return redirect('/admin/manage/size_chart?alert=failed');
        }

    }
}
