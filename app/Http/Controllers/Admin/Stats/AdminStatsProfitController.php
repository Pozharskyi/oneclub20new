<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.10.2016
 * Time: 11:15
 */

namespace App\Http\Controllers\Admin\Stats;

use App\Interfaces\Controllers\Admin\Stats\AdminStatsInterface;
use App\Models\Payment\Receive\PaymentsReceive;
use DB;

define('DATE_START', '2016-10-01');

/**
 * Getting profit information
 * for statistics includes
 * primary view, dates parsing, setting
 * graph data for chart
 * Class AdminStatsDeliveryController
 * @package App\Http\Controllers\Admin\Stats
 */
class AdminStatsProfitController extends AdminStatsConfigController implements AdminStatsInterface
{
    use AdminStatsDatesParserTrait;

    /**
     * Getting primary view
     * about profit
     * in Admin Statistics
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetStatsView()
    {
        $result = array();

        foreach ($this->categories as $category) {
            $dates = $this->actionGetStatisticsDates($category);
            $data = $this->actionGetDescriptionByDates($dates->start, $dates->end);

            $result[$category] = $data;
        }

        return view('admin.stats.profit', [
            'results' => $result,
        ]);
    }

    /**
     * Getting description in
     * diapason of dates
     * for Admin Statistics
     * category profit
     * @param $start
     * @param null $end
     * @return mixed
     */
    public function actionGetDescriptionByDates($start, $end = null)
    {
        $data = PaymentsReceive::dates($start, $end)
            ->get();

        return $data;
    }

    /**
     * Getting information for
     * a chart in Admin Statistics
     * category profit
     * @return string
     */
    public function actionGetDataForStatsChart()
    {
        $stats = PaymentsReceive::groupBy(DB::raw('DAY(created_at)'))
            ->orderBy('created_at')
            ->get([
                DB::raw('DATE(created_at) as day'),
                DB::raw('SUM(amount) as aggregate')
            ]);

        $daysBetween = $this->actionCreateDateRangeArray(DATE_START, date('Y-m-d'));

        $result = array();
        $foundDays = array();

        foreach ($stats as $stat) {
            $foundDays[$stat->day] = $stat->aggregate;
        }

        foreach ($daysBetween as $day) {
            if (isset($foundDays[$day])) {
                $aggregate = $foundDays[$day];
            } else {
                $aggregate = 1;
            }

            $result[] = array(
                'date' => $day,
                'price' => round($aggregate),
            );
        }

        return json_encode($result);
    }

}