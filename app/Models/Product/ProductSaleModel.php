<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.09.2016
 * Time: 23:38
 */

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductSaleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_sales_categories';

    protected $fillable = [
        'sale_title', 'sale_start',
        'sale_end', 'discount'
    ];

    /**
     * Get all sub products with this size.
     */
    public function product()
    {
        return $this->hasOne(ProductModel::class, 'sale_id');
    }
}