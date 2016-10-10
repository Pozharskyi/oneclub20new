<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductIndexPricesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_index_price';

    protected $fillable = [
        'product_id', 'index_price',
        'final_price', 'special_price',
        'product_marga', 'retail_price',
    ];

    public function subProduct()
    {
        return $this->belongsTo(SubProductModel::class, 'sub_product_id');
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
