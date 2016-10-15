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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_product_color';

    protected $fillable = [
        'name', 'made_by',
    ];

    /**
     * Get all sub products with this color.
     */
    public function product()
    {
        return $this->hasMany(ProductModel::class, 'dev_product_color_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function scopeFindByColorName(Builder $query, $colorName)
    {
        $query->where('name', $colorName);

        return $query;
    }
}