<?php

use App\Models\SizeChart\MeasurementModel;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SizeChartReadTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * on url /admin/manage/size_chart should see all sizeCharts
     * should see sizeChart info, if sizeChart->measurements->name does not exist should see '-' else see $sizeChar->measurements->value
     */
    public function testGetAllSizeChartsInfo()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $role = \App\Models\User\RoleModel::first();    //get СуперАдмин роль
        $user->roles()->attach($role);
        $this->be($user);


        $sizeCharts = SizeChartModel::with(['measurements.name', 'brand', 'size', 'category'])->get();


        $this->call('GET', 'admin/manage/size_chart');
        foreach ($sizeCharts as $sizeChart) {
            $this->see($sizeChart->brand_size);
            $this->see($sizeChart->brand->name);
            $this->see($sizeChart->size->name);
            $this->see($sizeChart->category->category_name);

            $allMeasurements = MeasurementModel::where('size_chart_id', $sizeChart->id)->get();

            $sizeChartNamesIds = $sizeChart->measurements->pluck('measurements_names_id')->toArray();

            //should see sizeChart's measurement's value if exist, else should see '-'
            foreach($allMeasurements as $measurement){
                if (in_array($measurement->name->id,
                    $sizeChartNamesIds)) {
                    $this->seeInElement('#sizeChart_'.$sizeChart->id.' .measurementName_'.$measurement->name->id, $measurement->value);
                } else {
                    $this->seeInElement('#sizeChart_'.$sizeChart->id.' .measurementName_'.$measurement->name->id,'-');
                }
            }
        }

    }
}
