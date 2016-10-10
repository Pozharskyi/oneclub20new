<?php

namespace App\Http\Controllers\Admin\Manage\SizeChart;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\Basic\BasicBrandsModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductSizeModel;
use App\Models\SizeChart\MeasurementModel;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageSizeChartUpdateController extends Controller implements AdminImportUpdateInterface
{

    public function actionGetUpdateView($size_chart_id)
    {
        $sizeChart = SizeChartModel::with(['brand', 'category', 'size', 'measurements.name'])
            ->find($size_chart_id);

        //get 3-d level categories
        $categories = CategoryModel::all(['id', 'category_name', 'parent_id']);
        $newCategories = Collection::make();
        foreach ($categories as $category) {
            if (isset($category->parent->parent)) {
                $newCategories->push($category);
            }
        }

        $brands = BasicBrandsModel::all(['id', 'brand_name']);
        $sizes = ProductSizeModel::all(['id', 'name']);

        $measurementsNames = MeasurementNameModel::all(['id', 'name']);

        return view('admin.manage.size_chart.update', compact('sizeChart', 'brands', 'sizes', 'measurementsNames'))
            ->with('categories', $newCategories);
    }

    /**
     * Getting update method
     * @param Request $request
     * @return mixed
     */
    public function actionUpdate(Request $request)
    {

        $sizeChart = SizeChartModel::findOrFail($request->size_chart_id);
        $sizeChart->update($request->all());

        //get id from measurement name table
        $nameIds = $request->input('nameIds');

        //get values for  measurement name
        $values = $request->input('values');
        //get oldMeasurements from old sizeChart
        $measurements = $sizeChart->measurements()->get();

        //save Measurements
        foreach ($nameIds as $nameId) {

            //if new name added - create new measurements
            if (! $measurements->pluck('name_id')->search($nameId)) {
                $measurement = new MeasurementModel([
                    'value' => $values[$nameId - 1],             //get value for  measurement name
                    'measurements_names_id' => $nameId,
                ]);
                $measurement->sizeChart()->associate($sizeChart);
                $measurement->save();

                //update existed measurements
            } else {
                //get old measurements by $nameId and update
                $measurement = $measurements->where('name_id', $nameId)->first();
                $measurement->update(
                    ['value' => $values[$nameId - 1],             //get value for  measurement name
                        'measurements_names_id' => $nameId,
                    ]);
            }

        }
        //if removed existed
        foreach($measurements->pluck('name_id') as $existedNameId){
            if(! in_array($existedNameId, $nameIds)){
                $measurement = $measurements->where('name_id',$existedNameId)->first();
                $measurement->delete();
            }
        }
        return redirect( '/admin/manage/size_chart?alert=success' );
    }

}
