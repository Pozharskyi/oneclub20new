<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 10:50
 */

namespace App\Models\Product;

use App\Models\Basic\BasicGenderModel;
use App\Models\Category\SubCategoriesModel;
use App\Models\Import\ImportLogPartiesModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\CategoryModel;
use App\Models\Basic\BasicBrandsModel;
use App\Models\Shop\Basket\BasketModel;
use App\Models\Shop\ShopModel;
use App\Models\Product\ProductIndexPricesModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_index';

    protected $fillable = [
        'sku', 'product_store_id', 'product_backend_id',
        'brand_id', 'category_id', 'dev_index_gender_id',
        'stock_id',
    ];

    public function brand()
    {
        return $this->belongsTo(ProductBrandsModel::class, 'brand_id');
    }

    public function gender()
    {
        return $this->belongsTo(BasicGenderModel::class, 'dev_index_gender_id');
    }

    //delete after check import
    public function productGenders()
    {
        return $this->belongsTo(ProductGenderModel::class, 'dev_index_gender_id');
    }

    public function subProducts()
    {
        return $this->hasMany(SubProductModel::class, 'dev_product_index_id');
    }

    public function description()
    {
        return $this->hasOne(ProductDescriptionModel::class, 'product_id');
    }

    public function stock()
    {
        return $this->belongsTo(ProductStockModel::class, 'stock_id');
    }

    public function sale()
    {
        return $this->hasOne(ProductSaleModel::class, 'id');
    }

    public function logParties()
    {
        return $this->hasMany(ImportLogPartiesModel::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function scopeCategories( Builder $query, $categories )
    {
        if( !empty( $categories ) )
        {
            $query->whereIn( 'category_id', $categories );
        }
    }
}