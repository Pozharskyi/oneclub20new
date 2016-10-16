<?php

namespace App;

use App\Models\Basic\BasicBrandsModel;
use App\Models\Import\ImportIndexPartiesModel;
use App\Models\Import\ImportIndexSalesModel;
use App\Models\Import\ImportIndexSuppliersModel;
use App\Models\Import\ImportPartiesFileAllocationModel;
use App\Models\Discount\DiscountsModel;
use App\Models\Import\ImportPartiesLogDeleteModel;
use App\Models\Import\ImportPartiesLogEditModel;
use App\Models\Import\ImportSalesAssociationLogModel;
use App\Models\Import\ImportSalesAssociationModel;
use App\Models\Import\ImportSalesLogDeleteModel;
use App\Models\Import\ImportSalesLogEditModel;
use App\Models\Loging\LogUserModel;
use App\Models\Order\OrderModel;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductSizeModel;
use App\Models\User\RoleModel;
use App\Models\User\UserBalanceModel;
use App\Models\User\UsersBonusesModel;
use App\Models\User\UsersCategoryModel;
use Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Loging\LogUserBonuses;
use App\Models\Subscribation\SubscribationModel;

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

    public function supplier()
    {
        return $this->hasMany(ImportIndexSuppliersModel::class, 'id', 'made_by');
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

    public function partiesMadeBy()
    {
        return $this->hasMany(ImportIndexPartiesModel::class, 'id', 'made_by');
    }

    public function partiesBuyerId()
    {
        return $this->hasMany(ImportIndexPartiesModel::class, 'id', 'buyer_id');
    }

    public function partiesSupportId()
    {
        return $this->hasMany(ImportIndexPartiesModel::class, 'id', 'support_id');
    }

    public function salesMadeBy()
    {
        return $this->hasMany(ImportIndexSalesModel::class, 'id', 'made_by');
    }

    public function salesBuyerId()
    {
        return $this->hasMany(ImportIndexSalesModel::class, 'id', 'buyer_id');
    }

    public function partiesLogDeleteMadeBy()
    {
        return $this->hasMany(ImportPartiesLogDeleteModel::class, 'id', 'made_by');
    }

    public function partiesLogEditMadeBy()
    {
        return $this->hasMany(ImportPartiesLogEditModel::class, 'id', 'made_by');
    }

    public function salesLogDeleteMadeBy()
    {
        return $this->hasMany(ImportSalesLogDeleteModel::class, 'id', 'made_by');
    }

    public function salesLogEditMadeBy()
    {
        return $this->hasMany(ImportSalesLogEditModel::class, 'id', 'made_by');
    }

    public function salesAssociationMadeBy()
    {
        return $this->hasMany(ImportSalesAssociationModel::class, 'id', 'made_by');
    }

    public function salesAssociationLogMadeBy()
    {
        return $this->hasMany(ImportSalesAssociationLogModel::class, 'id', 'made_by');
    }


    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'dev_user_role', 'user_id', 'role_id');
    }

    /**
     * @param $roleName
     * @return bool
     * check if user has such role name
     */
    public function hasRole($roleName)
    {
        if ($this->roles()->where('name', $roleName)->first()) {
            return true;
        }
        return false;

    }


    /**
     * check if user has any of role with name in $roleNames
     * @param  $roleNames
     * @return bool
     *
     */
    public function hasRoles($roleNames)
    {
        if (is_array($roleNames)) {
            foreach ($roleNames as $roleName) {
                if ($this->hasRole($roleName)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasAnyRole()
    {
        if ($this->roles()->exists()) {
            return true;
        }

        return false;
    }

    public function scopeFilterByRoleId(Builder $query, $roleId)
    {
        $query->whereHas('roles', function ($q) use ($roleId) {
            $q->where('role_id', $roleId);
        });
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

    public function partiesFileAllocation()
    {
        return $this->hasMany(ImportPartiesFileAllocationModel::class, 'id', 'made_by');
    }
}
