<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.10.2016
 * Time: 0:50
 */

namespace App\Http\Controllers\Admin\Stats;

use App\Interfaces\Controllers\Admin\Stats\AdminStatsInterface;
use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Order\OrderModel;

/**
 * Getting delivery information
 * for statistics includes
 * primary view, dates parsing, setting
 * graph data for chart
 * Class AdminStatsDeliveryController
 * @package App\Http\Controllers\Admin\Stats
 */
class AdminStatsDeliveryController extends AdminStatsConfigController implements AdminStatsInterface
{
    /**
     * Getting delivery information
     * view for statistics
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

        return view('admin.stats.delivery', [
            'results' => $result,
        ]);
    }

    /**
     * Getting description based
     * on dates timestamp
     * @param $start
     * @param null $end
     * @return mixed
     */
    public function actionGetDescriptionByDates($start, $end = null)
    {
        $data = OrderModel::dates($start, $end)
            ->with(['orderDelivery', 'orderDelivery.deliveryType'])
            ->get();

        return $data;
    }

    /**
     * Getting information
     * for statistics
     * Chart drawing
     * @return string
     */
    public function actionGetDataForStatsChart()
    {
        $stats = DeliveryTypesModel::with(['orderDeliveries'])
            ->get();

        $result = array();

        foreach ($stats as $stat) {
            $result[] = array(
                'Типы доставки' => $stat->delivery_type,
                'Количество использований' => count($stat->orderDeliveries),
            );
        }

        return json_encode($result);
    }

}