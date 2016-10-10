<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 10:51
 */

namespace App\Models\Product;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSizeModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_size';

    protected $fillable = [
        'name', 'made_by',
    ];

    /**
     * Get all sub products with this size.
     */
    public function subproducts()
    {
        return $this->hasMany(SubProductModel::class, 'dev_product_size_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'made_by');
    }
}