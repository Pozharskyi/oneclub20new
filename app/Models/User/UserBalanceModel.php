<?php

namespace App\Models\User;

use App\User;
use Event;
use Illuminate\Database\Eloquent\Model;

class UserBalanceModel extends Model
{
    protected $table = 'dev_user_balance';

    protected $fillable = [
        'balance_amount'
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($userBalance) {
            Event::fire('App\Events\UserBalanceBeforeUpdated', $userBalance);
        });

        static:: updated(function ($userBalance) {
            Event::fire('App\Events\UserBalanceUpdated', $userBalance);
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
