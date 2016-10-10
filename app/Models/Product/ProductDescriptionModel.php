<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 10:51
 */

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductDescriptionModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_description';

    protected $fillable = [
        'product_name', 'product_id',
        'product_description', 'product_composition',
        'product_delivery_days', 'supplier_product_name',
        'comment_admin', 'comment_frontend',
        'country_manufacturer',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function scopeFindParent( Builder $query, $parentId )
    {
        return $query->where('product_id', $parentId);
    }

}