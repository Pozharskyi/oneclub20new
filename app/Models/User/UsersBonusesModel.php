<?php
namespace App\Models\User;

use App\Models\Loging\LogUserModel;
use App\User;
use Event;
use Illuminate\Database\Eloquent\Model;

class UsersBonusesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_users_bonuses';

    /**
     * Fields to fill
     */
    protected $fillable = array(
        'bonuses_amount', 'user_id',
    );

    public static function boot()
    {
        parent::boot();

        static::updating(function ($userBonus) {
            Event::fire('App\Events\UserBonusBeforeUpdated', $userBonus);
        });

        static:: updated(function ($userBonus) {
            Event::fire('App\Events\UserBonusUpdated', $userBonus);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userLogs()
    {
        return $this->hasMany(LogUserModel::class, 'user_id');
    }
}
