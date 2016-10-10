<?php

namespace App\Models\Basic;

use App\Models\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;

class BasicGenderModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_gender';

    protected $fillable = [
        'name'
    ];

//    public function products()
//    {
//        return $this->belongsToMany(ProductModel::class, 'dev_product_gender', 'dev_index_gender_id', 'dev_product_index_id');
//    }
    public function products()
    {
        return $this->hasMany(ProductModel::class, 'dev_index_gender_id');
    }
}
