<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductStockModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_stock';

    protected $fillable = ['stock'];

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'stock_id');
    }
}
