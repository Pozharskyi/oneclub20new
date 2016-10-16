<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 31.08.2016
 * Time: 11:10
 */

namespace App\Http\Controllers\User\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Loging\LogUserModel;
use App\Models\User\UsersBonusesModel;
use App\Models\Order\OrderModel;

class UserBonusController extends Controller
{
    /*
     * View assessed and use user of bonuses
     */
    public function ActionIndex(){
        $user_bonuses_amount = $this->getUserBonusesAmount();
        //$user_bonuses_loging_in = $this->getUserBonusesLogingIn();
        //$user_bonuses_loging_out = $this->getUserBonusesLogingOut();

        //$user_bonuses_loging = array_merge($user_bonuses_loging_in, $user_bonuses_loging_out);

        //krsort($user_bonuses_loging);

        $user_discount_log = $this->getUserDiscountsLog();

        $ar = $this->getUserBonuses();

        $user_bonuses_loging = array();

        $count_bonuses_log = count($ar);

        if($count_bonuses_log != 0){
            for($c = 0;$c < $count_bonuses_log;$c++){
                $cc = $c + 1;
                if($ar[$c]->field_changed == 'bonuses_amount' && $ar[$cc]->field_changed == 'bonuses_comment'){

                    if($ar[$c]->fromto['from'] > $ar[$c]->fromto['to']){
                        $type = 'out';
                        $amount = $ar[$c]->fromto['from'] - $ar[$c]->fromto['to'];
                    } else{
                        $type = 'in';
                        $amount = $ar[$c]->fromto['to'] - $ar[$c]->fromto['from'];
                    }

                    if(ctype_digit($ar[$cc]->fromto['to'])){
                        $comment = [
                            'order_id'          =>  $ar[$cc]->fromto['to'],
                            'public_order_id'   =>  $this->getOrderToBonusesLog($ar[$cc]->fromto['to']),
                        ];
                    } else{
                        $comment = $ar[$cc]->fromto['to'];
                    }

                    $user_bonuses_loging[] = array(
                        'amount'        =>  $amount,
                        'created_at'    =>  $ar[$c]->created_at,
                        'comment'       =>  $comment,
                        'type'          =>  $type,
                    );
                } else{
                    $c++;
                }
                $c++;
            }
        }

        return view('user.cabinet.bonus_list', [
            'user_bonuses_amount'   =>  $user_bonuses_amount,
            'user_bonuses_loging'   =>  $user_bonuses_loging,
            'user_discount_log'     =>  $user_discount_log,
            ]);
    }

    /*
     * Get user bonuses amount
     */
    private function getUserBonusesAmount(){
        $data = UsersBonusesModel::where('user_id', Auth::user()->id)
            ->get();

        return $data;
    }

    private function getOrderToBonusesLog($order_id){
        $data = OrderModel::where('id', $order_id)
            ->select('public_order_id')
            ->get();

        if(count($data) == 1){
            $result = $data[0]->public_order_id;
        } else{
            $result = '';
        }
        return $result;
    }

    private function getUserBonuses(){
        $result = LogUserModel::where('user_id',Auth::user()->id)
            ->where(function($query){
                $query->where('field_changed','bonuses_amount');
                $query->orWhere('field_changed','bonuses_comment');
            })
            ->with('fromto')
            ->get();
       return $result;
    }

    /*
     * Get, accrued user bonuses
     */
    /*private function getUserBonusesLogingIn(){
        $result = array();
        $data = LogUserBonuses::where('user_id',Auth::id())
            ->with('type')
            ->get();

        if(count($data) > 0){
            foreach($data as $val){
                $key = (int)strtotime($val->created_at);
                $result[$key] = [
                    'amount'        =>  $val->amount,
                    'created_at'    =>  $val->created_at,
                    'comment'       =>  $val->type['name'],
                    'type'          =>  'in',
                ];
            }
        }
        /*
         * Destroy object
         */
        //unset($data);

        //return $result;
    //}

    /*
     * Get, cancellation of user bonuses
     */
    /*private function getUserBonusesLogingOut(){
        $result = array();

        $data = OrderModel::whereHas('bonuses', function($query){
            $query->where('user_id', Auth::id());
        })
        ->with('bonuses')
        ->get();

        if(count($data) > 0){
            foreach($data as $val){
                $key = (int)strtotime($val->bonuses->created_at);
                $result[$key] = [
                    'amount'            =>  $val->bonuses->bonus_count,
                    'created_at'        =>  $val->bonuses->created_at,
                    'comment'           =>  [
                        'order_id'          =>  $val->id,
                        'public_order_id'   =>  $val->public_order_id,
                    ],
                    'type'              =>  'out',
                ];
            }
        }
        /*
         * Destroy object
         */
       // unset($data);

        //return $result;
    //}

    /*
     * Get, used user discounts (coupon)
     */
    private function getUserDiscountsLog(){
        $data = OrderModel::whereHas('discount', function($query) {
            $query->where('user_id', Auth::user()->id);
        })
        ->with('discount')
        ->get();

        return $data;
    }
}