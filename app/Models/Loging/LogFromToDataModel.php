<?php

namespace App\Models\Loging;

use Illuminate\Database\Eloquent\Model;

class LogFromToDataModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_log_from_to_data';

    protected $fillable = ['from', 'to'];

    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'fromto');
    }

    public function userLogs()
    {
        return $this->morphMany(LogUserModel::class, 'fromto');
    }
}
