<?php

use App\Models\SizeChart\SizeChartModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SizeChartDeleteTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * url /admin/manage/size_chart/delete
     */
    public function testDeleteSizeChartSucceed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        //get not empty sizeChart
        $sizeChart = SizeChartModel::with(['measurements'])->firstOrFail();
        $params = [
            'size_chart_id' => $sizeChart->id,
        ];

        $this->call('delete', '/admin/manage/size_chart/delete', $params);

        $this->notSeeInDatabase('dev_size_chart', ['id' => $sizeChart->id]);

        //should delete all measurements for this chart size
        foreach($sizeChart->measurements as $measurement){
            $this->notSeeInDatabase('dev_measurements', ['id' => $measurement->id]);
        }

        $this->assertResponseOk();
    }

    /**
     * url /admin/manage/size_chart/delete
     */
    public function testDeleteSizeChartFailed()
    {
        //for authentification
        $user = factory(\App\User::class)->create();
        $this->be($user);

        //get not empty sizeChart
        $sizeChart = SizeChartModel::firstOrFail();

        $params = [
            'size_chart_id' => 100,
        ];

        $this->call('delete', '/admin/manage/size_chart/delete', $params);

        $this->seeInDatabase('dev_size_chart', ['id' => $sizeChart->id]);

    }
}
