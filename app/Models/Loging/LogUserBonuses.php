<?php

namespace App\Models\Loging;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Bonuses\BonusesType;

class LogUserBonuses extends Model
{
    protected $table = 'dev_users_bonuses_log';

    protected $fillable = ['user_id', 'bonus_type_id', 'amount'];

    public function type(){
        return $this->belongsTo(BonusesType::class, 'bonus_type_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtAttribute($value){
        return (string) $value;
    }
}
