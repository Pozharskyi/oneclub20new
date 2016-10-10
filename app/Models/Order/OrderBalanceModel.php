<?php

namespace App\Models\Order;

use App\Models\Loging\LogOrderModel;
use Event;
use Illuminate\Database\Eloquent\Model;

class OrderBalanceModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_balance';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'balance_count', 'dev_order_index_id',
    ];

    public static function boot()
    {
        parent::boot();

        static ::updating(function($orderBalance){
            Event::fire('App\Events\Order\OrderBalanceBeforeUpdate', $orderBalance);
        });

        static :: updated(function($orderBalance){
            Event::fire('App\Events\Order\OrderBalanceUpdated', $orderBalance);
        });

    }

    public function order(){
        return $this->belongsTo(OrderModel::class, 'dev_order_index_id');
    }

    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }
}
