<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 30.08.2016
 * Time: 17:50
 */

namespace App\Http\Controllers\User\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderStatusModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Order\OrderModel;

class UserOrdersController extends Controller
{
    /*
     * Class shows all orders user, shows one user order
     */
    public function ActionIndex(){
        /*
         * show all user orders
         */
        $data = OrderModel::where('user_id', Auth::id())
            ->select('id','public_order_id','total_sum','created_at')
            ->orderBy('created_at', 'DESC')
            ->with(['statusOrderSubProduct' => function($query){
                $query
                    ->select('dev_order_status_list.user_status', 'dev_order_status_list.id')
                    ->groupBy('dev_order_index_sub_product.dev_order_index_id')
                    ->min('dev_order_index_sub_product.dev_order_status_list_id');
            }])
            ->paginate(2);

        //print_r($data);

        return view('user.cabinet.order_list',['data'=> $data]);
    }

    public function cancelUserOrder(){

    }

    public function orderDetails($order_id){
        /*
         * show one user_order
         * @incoming int $order_id
         */
        $data = OrderModel::where('id', $order_id)
            ->with(['orderDelivery',
                'subProducts',
                'subProducts.price',
                'subProducts.color',
                'subProducts.size',
                'subProducts.photos',
                'subProducts.product.description',
                'subProducts.product.brand',
            ])
            ->get();

        $obj_order_status = OrderStatusModel::all('id','user_status');

        $order_status = array();
        foreach($obj_order_status as $os){
            $order_status[$os->id] = $os->user_status;
        };

        return view('user.cabinet.order_details',['data'=> $data[0], 'order_status'=>$order_status]);
    }

}