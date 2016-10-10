<?php

namespace App\Models\Loging;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LogOrderModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_log';

    protected $dates = ['date'];

    protected $fillable = ['field_changed', 'author_id',
        'action_id', 'date', 'fromto_id',
        'fromto_type', 'loggable_id', 'loggable_type'];

    /**
     * The loggable relation
     * will return either a OrderPaymentModel or OrderDeliveryModel
     * or OrderContactDetailsModel or OrderStatusModel
     * or SubProductModel instances,
     * depending on which type of model owns the LogOrderModel.
     */
    public function loggable()
    {
        return $this->morphTo();
    }

    public function fromto()
    {
        return $this->morphTo();
    }

    public function logAction()
    {
        return $this->belongsTo(LogOrderActionModel::class, 'action_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
