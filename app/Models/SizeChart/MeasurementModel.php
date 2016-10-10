<?php

namespace App\Models\SizeChart;

use Illuminate\Database\Eloquent\Model;

class MeasurementModel extends Model
{
    protected $table = 'dev_measurements';
    protected $fillable = ['value', 'measurements_names_id'];

    public function name()
    {
        return $this->belongsTo(MeasurementNameModel::class, 'measurements_names_id');
    }

//    public function value()
//    {
//        return $this->belongsTo(MeasurementValueModel::class, 'measurements_values_id');
//    }

    public function sizeChart()
    {
        return $this->belongsTo(SizeChartModel::class, 'size_chart_id');
    }
}
