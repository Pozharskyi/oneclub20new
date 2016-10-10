<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 13:28
 */

namespace App\Models\Order;

use App\Models\Product\SubProductModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderIndexSubProductModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_index_sub_product';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'dev_sub_product_id', 'dev_order_index_id',
        'dev_order_status_list_id', 'price_for_one_product', 'qty'
    ];

    /*
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'dev_order_index_id', 'id');
    }
    */

    public function subProduct()
    {
        return $this->belongsTo(SubProductModel::class, 'dev_sub_product_id');
    }

    public function getQtyAttribute($value)
    {
        return round($value);
    }

    public function getPriceForOneProductAttribute($value)
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
