<?php

namespace App\Models\Subscribation;

use Illuminate\Database\Eloquent\Model;

class SubscribationModel extends Model
{
    protected $table = 'dev_subscribations';

    protected $fillable = array(
        'name', 'type',
    );

    public function type(){
        return $this->belongsTo(SubscribationTypeModel::class, 'id', 'type');
    }
}
