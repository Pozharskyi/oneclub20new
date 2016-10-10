<?php

namespace App\Models\SizeChart;

use App\Models\Basic\BasicBrandsModel;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductSizeModel;
use Illuminate\Database\Eloquent\Model;

class SizeChartModel extends Model
{
    protected $table = 'dev_size_chart';
    protected $fillable = ['brand_id', 'category_id', 'size_id', 'brand_size'];

    public function measurements()
    {
        return $this->hasMany(MeasurementModel::class, 'size_chart_id');
    }

    public function brand()
    {
        return $this->belongsTo(BasicBrandsModel::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSizeModel::class, 'size_id');
    }
}
