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
use App\Models\Payment\PaymentTypesModel;
use App\Models\Payment\Receive\PaymentsReceive;
use Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\Product\SubProductModel;
use App\Models\Discount\DiscountsModel;


class OrderModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_index';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'public_order_id', 'comment',
        'total_sum', 'total_quantity', 'original_sum'
    ];

    public static function boot()
    {
        parent::boot();

        static ::updating(function($orderIndex){
            Event::fire('App\Events\Order\OrderIndexBeforeUpdated', $orderIndex);
        });

        static :: updated(function($orderIndex){
            Event::fire('App\Events\Order\OrderIndexUpdated', $orderIndex);
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

    public function orderContactDetails()
    {
        return $this->hasOne(OrderContactDetailsModel::class, 'order_id');
    }

    public function orderPaymentType()
    {
        return $this->belongsTo(PaymentTypesModel::class, 'payment_type_id');
    }

    public function paymentReceive()
    {
        return $this->hasOne(PaymentsReceive::class, 'order_id', 'public_order_id');
    }

    public function orderDelivery()
    {
        return $this->hasOne(OrderDeliveryModel::class, 'order_id');
    }

    public function discount()
    {
        return $this->belongsTo(DiscountsModel::class, 'discount_id');
    }

    public function bonuses()
    {
        return $this->hasOne(OrderBonusesModel::class, 'dev_order_index_id');
    }

    public function balance()
    {
        return $this->hasOne(OrderBalanceModel::class, 'dev_order_index_id');
    }


    public function subProducts()
    {
        return $this->belongsToMany(SubProductModel::class, 'dev_order_index_sub_product', 'dev_order_index_id', 'dev_sub_product_id')->withPivot('dev_order_status_list_id', 'price_for_one_product', 'qty');
    }

    public function orderStatus(){
        return $this->belongsToMany(OrderStatusModel::class, 'dev_order_index_sub_product', 'dev_order_index_id', 'dev_order_status_list_id');
    }

    public function statusOrderSubProduct()
    {
        return $this->belongsToMany(OrderStatusModel::class, 'dev_order_index_sub_product','dev_order_index_id', 'dev_order_status_list_id');
    }

    public function scopeMinStatusOrderSubProduct()
    {
        $query = $this->statusOrderSubProduct()->getQuery();
        $query = $query->select('dev_order_status_list.user_status')
            ->groupBy('dev_order_index_sub_product.dev_order_index_id')
            ->min('dev_order_index_sub_product.dev_order_status_list_id');
        return $query;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDates(Builder $query, $start, $end)
    {
        $query->where('created_at', '>=', $start);

        if (!is_null($end)) {
            $query->where('created_at', '<', $end);
        }
    }

    public function getTotalQuantityAttribute($value)
    {
        return round($value);
    }

    public function getTotalSumAttribute($value)
    {
        return round($value);
    }

    public function orderItems()
    {
        return $this->hasOne(OrderIndexSubProductModel::class, 'dev_order_index_id');
    }

    //don't need because we have method in DiscountModel
//    public function scopeFilterByDiscountsIds(Builder $query, $discountIds)
//    {
//        $query = $query->whereIn('discount_id', $discountIds);
//
//        return $query;
//    }

}