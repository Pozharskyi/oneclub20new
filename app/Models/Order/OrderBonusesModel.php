<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 13:27
 */

namespace App\Models\Order;

use App\Models\Loging\LogOrderModel;
use Event;
use Illuminate\Database\Eloquent\Model;

class OrderBonusesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_index_bonus';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'bonus_count', 'dev_order_index_id',
    ];

    public static function boot()
    {
        parent::boot();

        static ::updating(function($orderBonuses){
            Event::fire('App\Events\Order\OrderBonusesBeforeUpdate', $orderBonuses);
        });

        static :: updated(function($orderBonuses){
            Event::fire('App\Events\Order\OrderBonusesUpdated', $orderBonuses);
        });

    }

    public function order(){
        return $this->belongsTo(OrderModel::class, 'dev_order_index_id');
    }

    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }

    public function getCreatedAtAttribute($value){
        return (string) $value;
    }

}