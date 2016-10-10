<?php

namespace App\Models\Loging;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LogUserModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_user_log';

    protected $dates = ['date'];

    protected $fillable = [
        'field_changed', 'author_id',
        'action_id', 'date', 'user_id',
        'fromto_id', 'fromto_type'
    ];

    public function logAction()
    {
        return $this->belongsTo(LogUserActionModel::class, 'action_id');
    }

    public function fromto()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function from_to_int(){
        return $this->hasMany(LogFromToIntModel::class, 'id', 'fromto_id');
    }

    public function from_to_string(){
        return $this->hasMany(LogFromToStringModel::class, 'id', 'fromto_id');
    }
}
