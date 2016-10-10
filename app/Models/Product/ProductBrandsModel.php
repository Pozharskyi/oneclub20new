<?php

namespace App\Models\Product;

use App\Models\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;

class ProductBrandsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_brands';

    protected $fillable = ['brand_name'];

    public function products(){
        return $this->hasMany(ProductModel::class, 'brand_id');
    }
}
