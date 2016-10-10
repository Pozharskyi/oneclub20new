<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 13:28
 */

namespace App\Models\Order;

use App\Models\Loging\LogOrderModel;
use Event;
use Illuminate\Database\Eloquent\Model;
use App\Models\Delivery\DeliveryTypesModel;

class OrderDeliveryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_delivery';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'delivery_type_id',
        'delivery_f_name', 'delivery_l_name',
        'delivery_phone', 'delivery_address',
    ];

    public static function boot()
    {
        parent::boot();

        static ::updating(function($orderDelivery){
            Event::fire('App\Events\Order\OrderDeliveryBeforeUpdate', $orderDelivery);
        });

        static :: updated(function($orderDelivery){
            Event::fire('App\Events\Order\OrderDeliveryUpdated', $orderDelivery);
        });

    }

    /**
     * Relation with LogOrderModel
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }
    //*//
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'id');
    }
    //*//
    public function deliveryType()
    {
        return $this->belongsTo(DeliveryTypesModel::class, 'delivery_type_id');
    }
}
