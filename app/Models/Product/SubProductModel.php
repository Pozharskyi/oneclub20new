<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 06.09.2016
 * Time: 18:59
 */

namespace App\Models\Product;



use App\Models\Import\ImportIndexSuppliersModel;
use App\Models\Order\OrderIndexSubProductModel;
use App\Models\Order\OrderStatusModel;
use App\Models\Shop\Basket\BasketModel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loging\LogOrderModel;
use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProductModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_sub_product';

    protected $fillable = [
        'barcode', 'dev_product_index_id',
        'dev_import_parties_id', 'quantity',
        'dev_product_size_id', 'dev_product_color_id',
        'supplier_id',
    ];

    public function price()
    {
        return $this->hasOne(ProductIndexPricesModel::class, 'sub_product_id');
    }

    public function size()
    {
        return $this->belongsTo(ProductSizeModel::class, 'dev_product_size_id');
    }

    public function supplier()
    {
        return $this->belongsTo(ImportIndexSuppliersModel::class, 'supplier_id');
    }

    public function photos()
    {
        return $this->hasMany(ProductPhotoModel::class, 'dev_product_index_id');
    }
    /**
     * Relation with LogOrderModel
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orderLogs()
    {
        return $this->morphMany(LogOrderModel::class, 'loggable');
    }

    public function orders()
    {
        return $this->belongsToMany(OrderModel::class, 'dev_order_index_sub_product', 'dev_sub_product_id', 'dev_order_index_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'dev_product_index_id');
    }

    public function subProductSupplier(){
        return $this->hasMany(ImportIndexSuppliersModel::class, 'sub_product_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderIndexSubProductModel::class, 'dev_sub_product_id');
    }

    public function basket()
    {
        return $this->hasMany(BasketModel::class, 'sub_product_id');
    }

    public function statusOrderSubProduct()
    {
        return $this->belongsToMany(OrderStatusModel::class, 'dev_order_index_sub_product','dev_sub_product_id', 'dev_order_status_list_id');
    }

    public function scopeSizes( $query, $sizes )
    {
        // if any sizes
        if( $sizes != '' )
        {
            $sizes_array = explode( ",", $sizes );

            $query->where( function( $query ) use ( $sizes_array ) {

                $i = 0;
                $count = count( $sizes_array );

                while( $i < $count )
                {
                    if( $i == 0 )
                    {
                        $query->where( 'dev_product_size_id', $sizes_array[$i] );
                    } else
                    {
                        $query->orWhere( 'dev_product_size_id', $sizes_array[$i] );
                    }

                    $i++;
                }

            });
        }
    }

    public function scopeColors( $query, $colors )
    {
        // if any sizes
        if( $colors != '' )
        {
            $colors_array = explode( ",", $colors );

            $query->where( function( $query ) use ( $colors_array ) {

                $i = 0;
                $count = count( $colors_array );

                while( $i < $count )
                {
                    if( $i == 0 )
                    {
                        $query->where( 'dev_product_color_id', $colors_array[$i] );
                    } else
                    {
                        $query->orWhere( 'dev_product_color_id', $colors_array[$i] );
                    }

                    $i++;
                }

            });
        }

        $query->groupBy( 'dev_product_color_id', 'dev_product_index_id' );
    }

    public function scopeSearch( $query, $barcode )
    {
        $query->where( 'barcode', $barcode );
    }

    public function scopeParty(Builder $query, $partyId)
    {
        $query->where( 'dev_import_parties_id', $partyId);
    }

    public function scopeFinalSearch( Builder $query, $product_id, $barcode, $color_id, $size_id )
    {
        $query->where( 'dev_product_index_id', $product_id )
            ->where( 'barcode', $barcode )
            ->where( 'dev_product_color_id', $color_id )
            ->where( 'dev_product_size_id', $size_id );
    }

    public function scopeApproved( Builder $query )
    {
        $query->where( 'is_approved', '1' );
    }

    public function scopeCatalogItems( Builder $query, $type, $product_index_ids )
    {
        if( $type == 'list' )
        {
            $query->whereNotIn( 'dev_product_index_id', $product_index_ids );
        } else
        {
            $query->whereIn( 'dev_product_index_id', $product_index_ids );
        }

        return $query;
    }
}