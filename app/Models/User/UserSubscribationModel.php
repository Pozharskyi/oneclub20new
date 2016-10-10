<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserSubscribationModel extends Model
{
    protected $table = 'dev_users_subscribations';

    protected $fillable = array(
        'user_id', 'subscribation_id',
    );
}
