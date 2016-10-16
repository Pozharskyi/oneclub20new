<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 13:29
 */

namespace App\Models\Order;

use App\Models\Loging\LogOrderModel;
use Illuminate\Database\Eloquent\Model;

class OrderStatusModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_status_list';

    protected $fillable = ['user_status', 'admin_status'];

    /**
     * Relation with LogOrderModel
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }

    public function order()
    {
        return $this->hasMany();
    }

}