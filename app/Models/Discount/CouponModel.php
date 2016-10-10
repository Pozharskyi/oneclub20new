<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $table = 'dev_coupon';
    protected $fillable = ['coupon_code'];

    public function couponRule()
    {
        return $this->belongsTo(CouponRuleModel::class, 'coupon_rules_id');
    }
}
