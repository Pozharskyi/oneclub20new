<?php

namespace App\Models\Shop\Basket;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Product\SubProductModel;

class BasketModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_basket';

    /**
     * Fields to fill
     */
    protected $fillable = array(
        'user_id', 'sub_product_id',
        'sub_product_quantity',
    );

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function subProduct()
    {
        return $this->belongsTo(SubProductModel::class, 'sub_product_id', 'id');
    }

    public function getSubProductQuantityAttribute($value)
    {
        return round($value);
    }

    public function scopeUser( $query, $user_id, $selector )
    {
        if( !is_null( $selector ) )
        {
            if( !is_null( $user_id ) )
            {
                $query->where( 'user_id', '<>', $user_id );
            }
        } else
        {
            if( !is_null( $user_id ) )
            {
                $query->where( 'user_id', $user_id );
            }
        }
    }
}
