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

class OrderContactDetailsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_contact_details';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'f_name', 'l_name',
        'city', 'cell', 'email'
    ];

    /**
     * Relation with LogOrderModel
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public static function boot()
    {
        parent::boot();

        static ::updating(function($orderContactDetails){
            Event::fire('App\Events\Order\OrderContactDetailsBeforeUpdate', $orderContactDetails);
        });

        static :: updated(function($orderContactDetails){
            Event::fire('App\Events\Order\OrderContactDetailsUpdated', $orderContactDetails);
        });

    }

    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'id', 'order_id');
    }
}