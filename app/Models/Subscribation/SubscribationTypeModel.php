<?php

namespace App\Models\Subscribation;

use Illuminate\Database\Eloquent\Model;

class SubscribationTypeModel extends Model
{
    protected $table = 'dev_subscribations_type';

    protected $fillable = array(
        'name',
    );

    public function subscribation(){
        return $this->hasMany(SubscribationModel::class, 'type');
    }
}
