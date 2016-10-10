<?php

namespace App\Models\Loging;

use Illuminate\Database\Eloquent\Model;

class LogUserActionModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_user_log_action';

    protected $fillable = ['name'];

    public function userlogs()
    {
       return $this->hasMany(LogUserModel::class, 'action_id');
    }
}
