<?php

namespace App\Models\Payment;

use App\Models\Discount\DiscountsModel;
use App\Models\Loging\LogOrderModel;
use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderPaymentModel;

class PaymentTypesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_payment_types';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'U';

    protected $fillable = ['payment_type'];

    public function order()
    {
        return $this->hasOne(OrderModel::class, 'payment_type_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(DiscountsModel::class, 'dev_discount_payment_type', 'payment_type_id', 'discount_id');
    }
}
