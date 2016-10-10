<?php
namespace App\Models\Bonuses;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loging\LogUserBonuses;

class BonusesType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_bonuses_type';

    /**
     * Fields to fill
     */
    protected $fillable = array(
        'name',
    );

    public function logBonuses(){
        return $this->hasMany(LogUserBonuses::class, 'bonus_type_id');
    }
}
