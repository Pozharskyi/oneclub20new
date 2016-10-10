<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 04.10.2016
 * Time: 11:52
 */

namespace App\Http\Controllers\User\Cabinet;

use Illuminate\Support\Facades\Auth;
use App\Models\Order\OrderModel;

class UserDeliveryController
{
    /*
     * Get user address
     */
    public static function getUserDeliveryList(){
        $data = OrderModel::where('user_id',Auth::id())
            ->with('orderDelivery')
            ->get();

        return $data;
    }
}