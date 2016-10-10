<?php

namespace App;

use App\Models\Basic\BasicBrandsModel;
use App\Models\Import\ImportLogPartiesModel;
use App\Models\Import\ImportSalesAssociationModel;
use App\Models\Import\ImportSalesShareModel;
use App\Models\Import\ImportUpdateModel;
use App\Models\Discount\DiscountsModel;
use App\Models\Loging\LogUserModel;
use App\Models\Order\OrderModel;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductSizeModel;
use App\Models\Supplier\SupplierModel;
use App\Models\User\UserBalanceModel;
use App\Models\User\UsersBonusesModel;
use App\Models\User\UsersCategoryModel;
use Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Loging\LogUserBonuses;
use App\Models\Subscribation\SubscribationModel;
use App\Models\Import\ImportPartiesModel;

class User extends Authenticatable
{
//    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // CUSTOM FIELDS
        'f_name',
        'l_name',
        'phone',
        'gender',
        'date_of_birth',
        'provider',
        'social_id',
        // END CUSTOM FIELDS
    ];


//    protected $dates = ['date_of_birth'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            Event::fire('App\Events\UserCreated', $user);
        });

        static::updating(function ($user) {
            Event::fire('App\Events\UserBeforeUpdated', $user);
        });

        static:: updated(function ($user) {
            Event::fire('App\Events\UserUpdated', $user);
        });

        static:: deleted(function ($user) {
            Event::fire('App\Events\UserDeleted', $user);
        });
    }

    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'user_id');
    }

    public function authorLogs()
    {
        return $this->hasMany(LogUserModel::class, 'author_id');
    }

    public function userLogs()
    {
        return $this->hasMany(LogUserModel::class, 'user_id');
    }

    public function bonuses()
    {
        return $this->hasOne(UsersBonusesModel::class, 'user_id');
    }

    public function balances()
    {
        return $this->hasOne(UserBalanceModel::class, 'user_id');
    }

    public function bonusesLog()
    {
        return $this->hasMany(LogUserBonuses::class, 'user_id');
    }

    public function subscribe()
    {
        return $this->belongsToMany(SubscribationModel::class, 'dev_users_subscribations', 'user_id',
            'subscribation_id')->withPivot('user_id', 'subscribation_id');
    }

    public function importParties()
    {
        return $this->hasMany(ImportPartiesModel::class, 'made_by');
    }

    public function importSalesShare()
    {
        return $this->hasMany(ImportSalesShareModel::class, 'made_by');
    }

    public function salesAssociation()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'id', 'made_by');
    }

    public function logParties()
    {
        return $this->hasMany(ImportLogPartiesModel::class, 'id', 'made_by');
    }

    public function supplier()
    {
        return $this->hasMany(SupplierModel::class, 'id', 'made_by');
    }

    public function brand()
    {
        return $this->hasMany(BasicBrandsModel::class, 'id', 'made_by');
    }

    public function size()
    {
        return $this->hasMany(ProductSizeModel::class, 'id', 'made_by');
    }

    public function color()
    {
        return $this->hasMany(ProductColorModel::class, 'id', 'made_by');
    }

    public function importUpdate()
    {
        return $this->hasMany(ImportUpdateModel::class, 'id', 'made_by');
    }

    /**
     * Scope a query to only include users which contain a searching text in the user's name or
     *  in the user's email
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchStr
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByQuery(Builder $query, $searchStr)
    {
        if ($searchStr) {
            $query = $query->where('name', 'LIKE', '%' . $searchStr . '%')
                ->orWhere('email', 'LIKE', '%' . $searchStr . '%');
        }

        return $query;
    }

    public function usersCategories()
    {
        return $this->belongsToMany(UsersCategoryModel::class, 'dev_users_index_categories', 'user_id', 'category_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(DiscountsModel::class, 'dev_discount_user', 'user_id', 'discount_id');
    }
}
