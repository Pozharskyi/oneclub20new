<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 31.08.2016
 * Time: 16:52
 */

namespace App\Http\Controllers\Shop\Order;

use App\Http\Controllers\Controller;

use App\Models\User\UsersBonusesModel;
use App\Models\Order\OrderBonusesModel;

/**
 * Bonuses validation for Order
 * Class OrderBonusesController
 * @package App\Http\Controllers\Shop\Order
 */
class OrderBonusesController extends Controller
{
    /**
     * Validating if user have enough bonuses
     * for Order
     * @param $user_id
     * @param $bonuses_amount
     * @return bool
     */
    public static function actionValidateUserBonuses( $user_id, $bonuses_amount )
    {
        if($bonuses_amount == 0){
            return false;
        }
        // getting bonuses
        $bonuses = UsersBonusesModel::where('user_id', '=', $user_id)
            ->where('bonuses_amount', '>=', $bonuses_amount)
            ->first(['id']);

        // if no bonuses
        if( count( $bonuses ) == 0 )
        {
            return false;
        } else
        {
            return $bonuses->id;
        }

    }

    /**
     * Update user bonuses if order success
     * @with Transaction
     * @param $id
     * @param $bonuses_amount
     */
    public static function actionUpdateBonuses( $id, $bonuses_amount )
    {
        $bonuses = UsersBonusesModel::findOrFail( $id );

        $bonuses->bonuses_amount -= $bonuses_amount;

        $bonuses->save();
    }

    /**
     * Inserting used bonuses in order
     * @param $order_id
     * @param $bonuses_amount
     * @return OrderBonusesModel
     */
    public static function actionInsertBonuses( $order_id, $bonuses_amount )
    {
        return OrderBonusesModel::create([
            'bonus_count' => $bonuses_amount,
            'dev_order_index_id' => $order_id,
        ]);
    }

}