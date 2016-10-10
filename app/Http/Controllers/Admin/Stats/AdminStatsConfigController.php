<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 22:02
 */

namespace App\Http\Controllers\Admin\Stats;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Stats\AdminStatsConfigInterface;

/**
 * Setting config for statistics
 * in Admin page
 * Class AdminStatsConfigController
 * @package App\Http\Controllers\Admin\Stats
 */
class AdminStatsConfigController extends Controller implements AdminStatsConfigInterface
{
    /**
     * Categories in russian format
     * @var
     */
    protected $categories;

    /**
     * Setting categories by default
     * AdminStatsConfigController constructor.
     */
    public function __construct()
    {
        $this->actionSetCategories();
    }

    /**
     * Getting timestamps by russian
     * format strings
     * Getting start as well as end
     * @param $timeString
     * @return \stdClass
     * @throws \Exception
     */
    public function actionGetStatisticsDates($timeString)
    {
        switch ($timeString) {
            case 'Сегодня':
                $start = date('Y-m-d', strtotime('today'));
                $end = null;
                break;

            case 'Вчера':
                $start = date('Y-m-d', strtotime('yesterday'));
                $end = date('Y-m-d', strtotime('today'));
                break;

            case 'Неделю':
                $start = date('Y-m-d', strtotime('-7 days'));
                $end = null;
                break;

            case 'Текущий месяц':
                $start = date('Y-m-d', strtotime('first day of this month'));
                $end = null;
                break;

            case 'Преведущий месяц':
                $start = date('Y-m-d', strtotime('first day of last month'));
                $end = date('Y-m-d', strtotime('first day of this month'));
                break;

            default:
                throw new \Exception('Date not found. StatisticsController@actionGetStatisticsByDate');
        }

        $dates = new \stdClass();
        $dates->start = $start;
        $dates->end = $end;

        return $dates;
    }

    /**
     * Setting categories to
     * parse stats
     */
    public function actionSetCategories()
    {
        $categories = array(
            'Сегодня',
            'Вчера',
            'Неделю',
            'Текущий месяц',
            'Преведущий месяц',
        );

        $this->categories = $categories;
    }

}