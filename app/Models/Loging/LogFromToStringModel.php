<?php

namespace App\Models\Loging;

use Illuminate\Database\Eloquent\Model;

class LogFromToStringModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_log_from_to_string';

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
