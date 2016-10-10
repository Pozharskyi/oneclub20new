<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Discount\CouponModel;
use App\Models\Discount\CouponRuleModel;
use App\Models\Discount\DiscountsModel;
use App\Models\Payment\PaymentTypesModel;
use App\Models\User\UsersCategoryModel;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class AdminPanelDiscountController extends Controller
{
    public function createDiscount(Request $request)
    {
        $deliveryTypes = DeliveryTypesModel::all();
        $paymentTypes = PaymentTypesModel::all();
        $usersCategories = UsersCategoryModel::all(['category', 'id']);
        return view('admin.panel.discounts.create')
            ->with('deliveryTypes', $deliveryTypes)
            ->with('paymentTypes', $paymentTypes)
            ->with('usersCategories', $usersCategories);
    }

    public function storeDiscount(Request $request)
    {

        // begin Transaction
        DB::beginTransaction();

        try {
            $discount = new DiscountsModel($request->all());
            $discount->save();

            $deliveryTypes = DeliveryTypesModel::findOrFail($request->deliveryTypes);
            $discount->deliveryTypes()->attach($deliveryTypes);

            $paymentTypes = PaymentTypesModel::findOrFail($request->paymentTypes);
            $discount->paymentTypes()->attach($paymentTypes);

            $couponRule = new CouponRuleModel([
                'max_used_user' => $request->max_used_user,
                'max_used_all' => $request->max_used_all
            ]);
            $couponRule->save();
            $discount->couponRule()->associate($couponRule);
            $discount->save();

            $userCategories = UsersCategoryModel::findOrFail($request->usersCategoryIds);
            $discount->usersCategories()->attach($userCategories);

            $couponAmount = $request->coupon_amount;
            if ($request->coupon_generate == "on") {
                $this->createCouponCodesRandom($couponAmount, $couponRule);
            } else {
                $couponCodeName = $request->coupon_code_name;

                $this->createCouponCodesByName($couponAmount, $couponRule, $couponCodeName);
            }
            // if succeed do
            DB::commit();
        } catch (\Exception $e) {
            // else rollback all queries
            DB::rollBack();
            return 'Bad request';
        }

        Session::flash('message', 'Discount has been created');

        return redirect()->route('adminTable.users.searchUser');
    }

    public function getDiscounts(Request $request)
    {

    }

    public function editDiscount(Request $request, $discountId)
    {

    }

    public function updateDiscount(Request $request, $discountId)
    {

    }

    public function deleteDiscount(Request $request, $discountId)
    {

    }

    public function showDiscount(Request $request, $discountId)
    {
        $discount = DiscountsModel::with(['deliveryTypes', 'paymentTypes', 'usersCategories'])->findOrFail($discountId);

        return view('admin.panel.discounts.show')->with('discount', $discount);
    }

    /**
     * @param $couponAmount
     * @param $couponRule
     */
    private function createCouponCodesRandom($couponAmount, $couponRule)
    {
        //get all couponCodes from BD to prevent same couponCodes
        $couponCodes = CouponModel::pluck('coupon_code')->toArray();

        for ($i = 0; $i < $couponAmount; $i++) {

            //check if couponCode name already exist
            do {
                $code = str_random(6);
            } while (in_array($code, $couponCodes));

            array_push($couponCodes, $code);

            $coupon = new CouponModel(['coupon_code' => $code]);
            $coupon->couponRule()->associate($couponRule);
            $coupon->save();
        }
    }

    private function createCouponCodesByName($couponAmount, $couponRule, $couponCodeName)
    {

        for ($i = 0; $i < $couponAmount; $i++) {
            $coupon = new CouponModel(['coupon_code' => $couponCodeName]);
            $coupon->couponRule()->associate($couponRule);
            $coupon->save();
        }
    }
}
