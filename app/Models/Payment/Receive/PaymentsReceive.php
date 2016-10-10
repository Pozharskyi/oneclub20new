<?php

namespace App\Models\Payment\Receive;

use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentsReceive extends Model
{
    //
    protected $table = 'dev_payments_receives';
    protected $fillable = ['order_id','paytype','pay_system_order_id',
                            'email','phone','ip','amount',
                            'commission','currency','description',
                            'type','transaction_id','orderDateTime',
                            'payment_status'];

    public function order()
    {
        return $this->hasOne(OrderModel::class, 'order_id');
    }

    public function getAmountAttribute($value)
    {
        return round($value);
    }

    public function getCommissionAttribute($value)
    {
        return round($value);
    }

    public function scopeDates(Builder $query, $start, $end)
    {
        $query->where('created_at', '>=', $start);

        if (!is_null($end)) {
            $query->where('created_at', '<', $end);
        }
    }
}
