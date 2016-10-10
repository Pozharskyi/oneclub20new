<?php

namespace App\Models\Delivery;

use App\Models\Discount\DiscountsModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderDeliveryModel;

class DeliveryTypesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_delivery_types';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'U';

    public $fillable = ['delivery_type'];

    public function orderDeliveries()
    {
        return $this->hasMany(OrderDeliveryModel::class, 'delivery_type_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(DiscountsModel::class, 'dev_discount_delivery_type', 'payment_type_id', 'discount_id');
    }
}
