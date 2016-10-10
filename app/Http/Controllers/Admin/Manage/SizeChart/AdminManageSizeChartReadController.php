<?php

namespace App\Http\Controllers\Admin\Manage\SizeChart;

use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\SizeChart\MeasurementNameModel;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageSizeChartReadController extends Controller implements AdminImportReadInterface
{
    /**
     * Getting read method
     * @param Request $request
     * @return mixed
     */
    public function actionRead(Request $request)
    {
        $alert = $request->input('alert');

        if (!isset($alert)) {
            $alert = false;
        }

        $measurementNames = MeasurementNameModel::all(['id', 'name']);
        $sizeCharts = SizeChartModel::with(['measurements.name', 'brand', 'size', 'category'])->get();
//        dd($sizeCharts);
//        dd($measurementNames->toArray());
        return view('admin.manage.size_chart.read', compact('sizeCharts', 'alert', 'measurementNames'));
    }
}
