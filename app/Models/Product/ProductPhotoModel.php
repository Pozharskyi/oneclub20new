<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 10:51
 */

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductPhotoModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_photo';

    protected $fillable = [
        'sub_product_id', 'photo'
    ];

    /**
     * Get all sub products with this size.
     */
    public function subProduct()
    {
        return $this->belongsTo(SubProductModel::class, 'sub_product_id');
    }
}
