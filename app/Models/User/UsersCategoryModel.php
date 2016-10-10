<?php

namespace App\Models\User;

use App\Models\Discount\DiscountsModel;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersCategoryModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_users_categories';

    /**
     * Fields to fill
     */
    protected $fillable = array(
        'category', 'min_price', 'max_price'
    );

    public function users()
    {
        return $this->belongsToMany(User::class, 'dev_users_index_categories', 'category_id', 'user_id');
    }

    public function usersCategoriesSales()
    {
        return $this->hasMany(UsersCategoriesSaleModel::class, 'person_category_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(DiscountsModel::class,
            'dev_discount_users_categories',
            'users_categories_id',
            'discount_id');
    }
}
