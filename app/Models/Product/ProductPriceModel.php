<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 10:50
 */

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductPriceModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_index_price';

    protected $fillable = [
        'sub_product_id', 'index_price',
        'final_price', 'special_price',
        'sale_percent', 'product_marga',
        'retail_price',
    ];

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function scopePrices( $query, $min, $max )
    {
        if( $min != '' )
        {
            $query->where( 'special_price', '>=', $min );
        }

        if( $max != '' )
        {
            $query->where( 'special_price', '<=', $max );
        }
    }
}