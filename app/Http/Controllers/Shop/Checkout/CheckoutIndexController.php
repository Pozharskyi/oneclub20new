<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.08.2016
 * Time: 17:28
 */

namespace App\Http\Controllers\Shop\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Basic\DiscountsController;
use App\Http\Controllers\Shop\Order\OrderPricesController;
use App\Http\Controllers\Shop\Users\UsersBalanceController;
use App\Http\Controllers\Shop\Users\UsersBonusesController;
use App\Http\Controllers\Shop\Checkout\CheckoutProductValidationController;

use App\Models\Shop\Basket\BasketModel;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Payment\PaymentTypesModel;

/**
 * Main entry point for checkout
 * Class CheckoutIndexController
 * @package App\Http\Controllers\Shop\Checkout
 */
class CheckoutIndexController extends Controller
{
    /**
     * Getting an user id
     * @var
     */
    private $user_id;

    /**
     * Index point for getting data
     * To prepare checkout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function actionIndex()
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {

            $this->user_id = Auth::user()->id;
            $this->actionUpdateBasketReserve($this->user_id);

            // getting all payment types
            $payment_types = $this->actionGetPaymentTypes();

            // getting all delivery types
            $delivery_types = $this->actionGetDeliveryTypes();

            // getting all data about user
            // to fulfill
            $user = $this->actionCollectUserData();

            // getting user bonuses
            $bonuses = UsersBonusesController::actionGetUserBonuses($this->user_id);

            //getting user balance
            $balance = UsersBalanceController::actionGetUsersBalance($this->user_id);

            // getting data about products
            $products = OrderPricesController::actionGetPricesAndQuantityFromBasket($this->user_id);

            // return view
            return view('shop.checkout.index', [
                'user' => $user,
                'payment_types' => $payment_types,
                'delivery_types' => $delivery_types,
                'bonuses' => $bonuses,
                'products' => $products,
                'balance' => $balance,
            ]);
        }
    }

    /**
     * Getting data about user
     * @return mixed
     */
    public function actionCollectUserData()
    {

        $user = User::where('id', '=', $this->user_id)
            ->first(['f_name', 'l_name', 'phone', 'email']);

        return $user;
    }

    /**
     * Getting all payment types
     * @return mixed
     */
    public function actionGetPaymentTypes()
    {

        $types = PaymentTypesModel::get(['id', 'payment_type']);

        return $types;
    }

    /**
     * Getting all delivery types
     * @return mixed
     */
    public function actionGetDeliveryTypes()
    {

        $types = DeliveryTypesModel::get(['id', 'delivery_type']);

        return $types;
    }

    /**
     * Updating basket for reserve
     * for items
     * @param $user_id
     */
    private function actionUpdateBasketReserve($user_id)
    {
        $updated_at = date('Y-m-d H:i:s', strtotime('now +20 minutes'));

        BasketModel::where('user_id', $user_id)
            ->update(['updated_at' => $updated_at]);
    }

}