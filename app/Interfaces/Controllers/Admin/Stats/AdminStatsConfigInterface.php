<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.10.2016
 * Time: 18:00
 */

namespace App\Interfaces\Controllers\Admin\Stats;

/**
 * Setting config for Statistics
 * for Admin view
 * Interface AdminStatsConfigInterface
 * @package App\Interfaces\Controllers\Admin\Stats
 */
interface AdminStatsConfigInterface
{
    /**
     * Getting timestamps
     * based on string
     * in Russian format
     * @param $timeString
     * @return mixed
     */
    public function actionGetStatisticsDates($timeString);

    /**
     * Setting all strings
     * in Russian format for
     * getting timestamps
     * @return mixed
     */
    public function actionSetCategories();

}