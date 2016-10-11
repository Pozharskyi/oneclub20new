<?php

namespace App\Http\Controllers\Admin\Manage\SizeChart;

use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminManageSizeChartDeleteController extends Controller implements AdminImportDeleteInterface
{

    /**
     * Handle deletion
     * @param Request $request
     * @return mixed
     */
    public function actionDelete(Request $request)
    {

        $sizeChartId = $request->input('size_chart_id');
        $result = 'true';
        try {
            $sizeChart = SizeChartModel::findOrFail($sizeChartId);
            $ms = $sizeChart->measurements()->get();
            foreach ($ms as $m) {
                $m->delete();
            }
            $sizeChart->delete();

        } catch (\Exception $e) {
            $result = 'false';
        }

        return $result;
    }
}
