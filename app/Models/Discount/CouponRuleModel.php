<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;

class CouponRuleModel extends Model
{
    protected $table = 'dev_coupon_rules';
    protected $fillable = ['max_used_all', 'max_used_user'];

    public function discount()
    {
        return $this->hasOne(DiscountsModel::class, 'coupon_rules_id');
    }

    public function coupons()
    {
        return $this->hasMany(CouponModel::class, 'coupon_rules_id');
    }
}
