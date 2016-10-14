<?php

namespace App\Http\Controllers\Shop\Order;


use App\Http\Controllers\Shop\Basic\BalancesController;
use App\Models\Order\OrderBalanceModel;
use App\Models\User\UserBalanceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderBalanceController extends Controller
{

    public static $oldBalanceAmount;
    public static $newBalanceAmount;
    /**
     * Update user bonuses if order success
     * @with Transaction
     * @param $id
     * @param $balance_amount
     */
    public static function actionUpdateBalance( $id, $balance_amount )
    {
        $balance = UserBalanceModel::findOrFail( $id );

        $balance->balance_amount -= $balance_amount;

        $balance->save();
    }

//    /**
//     * Inserting used bonuses in order
//     * @param $order_id
//     * @param $balance_amount
//     * @return OrderBalanceModel
//     */
//    public static function actionInsertBalance( $order_id, $balance_amount )
//    {
//        return OrderBalanceModel::create([
//            'balance_count' => $balance_amount,
//            'dev_order_index_id' => $order_id,
//        ]);
//    }
    /**
     * @return OrderBalanceModel
     */
    public static function actionInsertBalance( $order_id )
    {
        $balance_count = self::$oldBalanceAmount - self::$newBalanceAmount;
        return OrderBalanceModel::create([
            'balance_count' => $balance_count,
            'dev_order_index_id' => $order_id,
        ]);
    }

    /**
     * @param $total
     * @return mixed
     * update userBalance
     * return total - with changed total_price after using balance in order
     */
    public static function changeTotalPriceUpdateBalanceUser($total)
    {
        $balance = BalancesController::getBalanceForUser();
        self::$oldBalanceAmount = $balance->balance_amount;

        if ($balance->balance_amount < $total->total_price) {
            $total->total_price -= $balance->balance_amount;
            $balance->balance_amount = 0;

            self::$newBalanceAmount = $balance->balance_amount;
            //update user_balance
            $balance->save();

            return $total;
        } else {
            $balance->balance_amount -= $total->total_price;
            $total->total_price = 0;

            self::$newBalanceAmount = $balance->balance_amount;
            //update user_balance
            $balance->save();

            return $total;
        }
    }
}
