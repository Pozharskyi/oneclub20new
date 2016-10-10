<?php

namespace App\Models\Loging;

use Illuminate\Database\Eloquent\Model;

class LogOrderActionModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_order_log_action';

    protected $fillable = ['name'];

    public function orderlogs()
    {
        return $this->hasMany(LogOrderModel::class, 'action_id');
    }
}
