<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.09.2016
 * Time: 11:20
 */

namespace App\Models\Basic;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicBrandsModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_brands';

    protected $fillable = [
        'brand_name', 'made_by',
    ];

    public function getProduct()
    {
        return $this->hasMany(ProductModel::class, 'brand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'made_by');
    }
}