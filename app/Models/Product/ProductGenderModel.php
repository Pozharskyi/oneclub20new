<?php

namespace App\Models\Product;

use App\Models\Basic\BasicGenderModel;
use Illuminate\Database\Eloquent\Model;

class ProductGenderModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_gender';

    protected $fillable = [
        'dev_product_index_id', 'dev_index_gender_id',
    ];

    public function gender()
    {
        return $this->hasOne(BasicGenderModel::class, 'id', 'dev_index_gender_id');
    }

    public function product()
    {
        return $this->hasMany(ProductModel::class, 'dev_index_gender_id');
    }
}
