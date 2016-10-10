<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.10.2016
 * Time: 17:55
 */

namespace App\Interfaces\Controllers\Admin\Stats;

/**
 * Main interface for statistics
 * Admin main page
 * Interface AdminStatsInterface
 * @package App\Interfaces\Controllers\Admin\Stats
 */
interface AdminStatsInterface
{
    /**
     * Getting view that includes
     * Graph, data by dates
     * @return mixed
     */
    public function actionGetStatsView();

    /**
     * Getting data for chart
     * in json format
     * @return mixed
     */
    public function actionGetDataForStatsChart();

    /**
     * Parsing description by dates
     * includes now, yesterday, week,
     * month and last month
     * @param $start
     * @param $end
     * @return mixed
     */
    public function actionGetDescriptionByDates($start, $end);

}