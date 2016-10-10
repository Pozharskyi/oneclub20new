<?php

namespace App\Models\Discount;

use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Payment\PaymentTypesModel;
use App\Models\User\UsersCategoryModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderModel;

class DiscountsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_index_discounts';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'status', 'discount_amount', 'active_from',
        'active_to', 'comment', 'rule',
        'auto', 'min_basket_sum', 'max_basket_sum',
        'type', 'subproduct_amount_from', 'purchase_number',
        'discount_id'
    ];

    /**
     * Hidden fields
     *
     * @var array
     */
    protected $hidden = [
        'discount_id',
    ];

    protected $dates = ['active_from', 'active_to'];

    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'discount_id');
    }

    public function deliveryTypes()
    {
        return $this->belongsToMany(DeliveryTypesModel::class, 'dev_discount_delivery_type', 'discount_id', 'delivery_type_id');
    }

    public function paymentTypes()
    {
        return $this->belongsToMany(PaymentTypesModel::class, 'dev_discount_payment_type', 'discount_id', 'payment_type_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'dev_discount_user', 'discount_id', 'user_id');
    }

    public function couponRule()
    {
        return $this->belongsTo(CouponRuleModel::class, 'coupon_rules_id');
    }

    public function usersCategories()
    {
        return $this->belongsToMany(UsersCategoryModel::class, 'dev_discount_users_categories', 'discount_id', 'users_categories_id');
    }

    public function scopeFilterByBasketSum(Builder $query, $basketSum)
    {
        $query = $query->where('min_basket_sum', '<=', $basketSum)
            ->where(function ($query) use ($basketSum) {
                $query->where('max_basket_sum', '>=', $basketSum)->orWhere('max_basket_sum', 0);
            });

        return $query;
    }

    public function scopeFilterByPurchaseNumber(Builder $query, $purchaseNumber)
    {
        $query = $query->where('purchase_number', '=', $purchaseNumber)->orWhere('purchase_number', 0);
        return $query;
    }

    public function scopeFilterBySubproductAmount(Builder $query, $subproductAmount)
    {
        $query = $query->where('subproduct_amount_from', '<=', $subproductAmount)
            ->orWhere('subproduct_amount_from', 0)
            ->orWhere('subproduct_amount_from', Null);
        return $query;
    }

    public function scopeFilterByData(Builder $query, $data)
    {
        $query = $query->where('active_from', '<=', $data)->where('active_to', '>=', $data);
        return $query;
    }

    public function scopeFilterByStatus(Builder $query)
    {
        $query = $query->where('status', 'Активный');
        return $query;
    }

    public function scopeFilterByPaymentType(Builder $query, $paymentType)
    {
        $query = $query->whereHas('paymentTypes', function ($q) use ($paymentType) {
            $q->where('payment_type_id', $paymentType);
        });
        return $query;
    }

    public function scopeFilterByDeliveryType(Builder $query, $deliveryType)
    {
        $query = $query->whereHas('deliveryTypes', function ($q) use ($deliveryType) {
            $q->where('delivery_type_id', $deliveryType);
        });
        return $query;
    }

    public function scopeFilterByUserCategories(Builder $query, $user)
    {
        $query = $query->whereHas('usersCategories', function ($q) use ($user) {
            $userCategoriesIds = $user->usersCategories()->get()->pluck('id');
            $q->whereIn('users_categories_id', $userCategoriesIds);
        });
        return $query;
    }

//    public function scopeFilterByCategoriesOrUser(Builder $query, $user)
//    {
//        $query = $query->where(function ($q) use ($user) {
//            $q->whereHas('usersCategories', function ($q) use ($user) {
//                $userCategoriesIds = $user->usersCategories()->get()->pluck('id');
//                $q->whereIn('users_categories_id', $userCategoriesIds);
//            });
//        })->orWhere(function ($q) use ($user) {
//            $q->whereHas('users', function ($q) use ($user) {
//                $q->where('user_id', $user->id);
//            });
//        });
//
//        return $query;
//    }

    public function scopeFilterByCategoriesOrUser(Builder $query, $user)
    {
        $query = $query->whereHas('usersCategories', function ($q) use ($user) {
            $userCategoriesIds = $user->usersCategories()->get()->pluck('id');
            $q->whereIn('users_categories_id', $userCategoriesIds);

        })->orWhereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        return $query;
    }

//    public function scopeFilterByUsedAllAmount(Builder $query)
//    {
//        $query = $query->whereHas('couponRule', function ($q) {
//            $usedAllAmount = $q->coupons()->count();
//           $q->where('max_used_all','>=', $usedAllAmount);
//        });
//        return $query;
//    }


    public function scopeWhereAuto(Builder $query)
    {
        $query = $query->where('auto', '1');
        return $query;
    }

    public function scopeWhereNotAuto(Builder $query)
    {
        $query = $query->where('auto', '0');
        return $query;
    }

    public function scopeFilterByUser(Builder $query, $userId)
    {
        $query = $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
        return $query;
    }

//START scopes use when discount auto = 0
    public function scopeGetCountOfUsedByUser(Builder $query, $user)
    {
        $query = $query->whereHas('orders', function ($q) use ($user) {
            $ordersIds = $user->orders()->get(['id']);
            $q->whereIn('id', $ordersIds);
        });

        return $query;
    }

    public function scopeGetCountOfUsedByAll(Builder $query)
    {
        $query = $query->whereHas('orders', function ($q) {
        });
        return $query;
    }

    public function scopeFilterByCouponRule(Builder $query, $usedAllAmount, $usedByUserAmount)
    {

        $query = $query->whereHas('couponRule', function ($q) use ($usedAllAmount, $usedByUserAmount) {
            $q->where(function ($query) use ($usedAllAmount) {
                $query->where('max_used_all', '>=', $usedAllAmount)->orWhere('max_used_all', 0);
            })->where(function ($query) use ($usedByUserAmount) {
                $query->where('max_used_user', '>=', $usedByUserAmount)->orWhere('max_used_user', 0);
            });
        });

        return $query;
    }

    public function scopeWhereCouponCode(Builder $query, $couponCode)
    {
        $query = $query->whereHas('couponRule.coupons', function ($q) use ($couponCode) {
            $q->where('coupon_code', $couponCode);
        });

        return $query;   //to get isCouponCodeCorrect add !result->get()->isEmpty()
    }
    //END scopes use when discount auto = 0

}
