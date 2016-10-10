<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 23:58
 */

namespace App\Http\Controllers\Admin\Stats;

use App\Interfaces\Controllers\Admin\Stats\AdminStatsInterface;
use App\Models\Order\OrderModel;
use App\Models\Payment\PaymentTypesModel;

/**
 * Getting payment information
 * for statistics includes
 * primary view, dates parsing, setting
 * graph data for chart
 * Class AdminStatsDeliveryController
 * @package App\Http\Controllers\Admin\Stats
 */
class AdminStatsPaymentsController extends AdminStatsConfigController implements AdminStatsInterface
{
    /**
     * Getting primary view for
     * Admin Statistics
     * about payments
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

        return view('admin.stats.payments', [
            'results' => $result,
        ]);
    }

    /**
     * Getting description
     * in diapason of dates
     * for statistics
     * @param $start
     * @param null $end
     * @return mixed
     */
    public function actionGetDescriptionByDates($start, $end = null)
    {
        $data = OrderModel::dates($start, $end)
            ->with(['orderPaymentType'])
            ->get();

        return $data;
    }

    /**
     * Getting data for a chart
     * in Admin Statistics
     * page of payments
     * @return string
     */
    public function actionGetDataForStatsChart()
    {
        $stats = PaymentTypesModel::with(['order'])->get();

        $result = array();

        foreach ($stats as $stat) {
            $result[] = array(
                'Типы оплат' => $stat->payment_type,
                'Количество использований' => count($stat->order),
            );
        }

        return json_encode($result);
    }

}