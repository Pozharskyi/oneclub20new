<?php

namespace App\Models\SizeChart;

use Illuminate\Database\Eloquent\Model;

class MeasurementNameModel extends Model
{
    protected $table = 'dev_measurements_names';
    protected $fillable = ['name'];

    public function measurements()
    {
        return $this->hasMany(MeasurementModel::class, 'measurements_names_id');
    }
}
