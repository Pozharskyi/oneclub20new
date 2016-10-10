<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UsersCategoriesSaleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_users_categories_sales';

    /**
     * Fields to fill
     */
    protected $fillable = [
        'product_min_price', 'product_min_price', 'product_min_price',
        'discount', 'brand_id', 'person_category_id', 'product_category'
    ];

    public function usersCategory()
    {
        return $this->belongsTo(UsersCategoryModel::class, 'person_category_id');
    }
}
