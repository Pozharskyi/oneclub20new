<?php

namespace App\Models\Basic;

use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Model;

class BasicDiscountsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_discounts';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'status',
    ];

    /**
     * Hidden fields
     *
     * @var array
     */
    protected $hidden = [
        'discount_id',
    ];

    protected $dates = ['active_from', 'active_to'];

    public function orders()
    {
        return $this->belongsToMany(OrderModel::class, 'dev_order_discount', 'dev_index_discounts_id', 'dev_order_index_id');
    }
}
