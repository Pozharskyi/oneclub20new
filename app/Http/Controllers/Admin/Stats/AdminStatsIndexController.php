<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 20:03
 */

namespace App\Http\Controllers\Admin\Stats;

use App\Interfaces\Controllers\Admin\Stats\AdminStatsInterface;
use App\Models\Order\OrderModel;
use DB;

define('DATE_START', '2016-10-01');

/**
 * Getting orders information
 * for statistics includes
 * primary view, dates parsing, setting
 * graph data for chart
 * Class AdminStatsDeliveryController
 * @package App\Http\Controllers\Admin\Stats
 */
class AdminStatsIndexController extends AdminStatsConfigController implements AdminStatsInterface
{
    use AdminStatsDatesParserTrait;

    /**
     * Getting primary view
     * for statistics about
     * orders
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

        return view('admin.index', [
            'results' => $result,
        ]);
    }

    /**
     * Getting orders description
     * for Admin statistics
     * @param $start
     * @param null $end
     * @return mixed
     */
    public function actionGetDescriptionByDates($start, $end = null)
    {
        $data = OrderModel::dates($start, $end)
            ->with(['user'])
            ->get();

        return $data;
    }

    /**
     * Getting data for a chart
     * Admin Statistics view
     * @return string
     */
    public function actionGetDataForStatsChart()
    {
        $stats = OrderModel::groupBy(DB::raw('DAY(created_at)'))
            ->orderBy('created_at')
            ->get([
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as aggregate')
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
                $aggregate = 0;
            }

            $result[] = array(
                'date' => $day,
                'value' => $aggregate,
            );
        }

        return json_encode($result);
    }

}