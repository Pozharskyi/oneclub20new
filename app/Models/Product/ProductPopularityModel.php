<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 20:12
 */

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductPopularityModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_popularity';

    protected $fillable = [
        'dev_product_index_id', 'popularity'
    ];

    public function product()
    {
        return $this->hasOne(ProductModel::class, 'id');
    }

}