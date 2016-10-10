<?php

namespace App\Http\Controllers\Admin\Panel;


//use App\Models\Delivery\DeliveryTypesModel;
use App\Http\Requests\Order\UpdateContactDetailsRequest;
use App\Http\Requests\Order\UpdateOrderDeliveryRequest;
use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Loging\LogOrderModel;
use App\Models\Order\OrderBalanceModel;
use App\Models\Order\OrderBonusesModel;
use App\Models\Order\OrderContactDetailsModel;
use App\Models\Order\OrderDeliveryModel;
use App\Models\Order\OrderDiscountModel;
use App\Models\Order\OrderPaymentModel;
use App\Models\Order\OrderModel;
use App\Models\Payment\PaymentTypesModel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use View;

/**
 * Class AdminPanelOrderController
 * @package App\Http\Controllers\Admin\Panel
 *
 * Class represent show all order's info
 * url /admin/users/{id}/orders/{1}
 * update each order's section by ajax request
 * show all order's logs
 * update logs for each sections in parts
 *
 */
class AdminPanelOrderController extends Controller
{
    /**
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * return all order's info with logs and subProducts
     */
    public function getUsersOrder(Request $request, $userId, $orderId)
    {

        $orderLogs = LogOrderModel::where('order_id', $orderId)
            ->orderBy('created_at', 'desc')
            ->with(['author', 'logAction', 'fromto'])->paginate(5);

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($orderLogs);

        //ajax paginate order logs
        if ($request->ajax()) {
            $order = OrderModel::findOrFail($orderId);
            return response()->json(View::make('admin.panel.orders.orderLogs', compact('orderLogs', 'order'))->render());
        }

        $order = OrderModel::with([
            'orderContactDetails', 'orderPaymentType',
            'orderDelivery.deliveryType', 'discount',
            'bonuses', 'balance', 'subProducts', 'statusOrderSubProduct' => function ($query) {
                $query->select('dev_order_status_list.*')
                    ->groupBy('dev_order_index_sub_product.dev_order_index_id')
                    ->min('dev_order_index_sub_product.dev_order_status_list_id');
            }
        ])->findOrFail($orderId);
//        dd($order);

        //get All needed entities to display in view
        $deliveryTypes = DeliveryTypesModel::all();
        $paymentTypes = PaymentTypesModel::all();
//        $orderStatus = $order->minStatusOrderSubProduct();

//        dd($orderLogs);
        return view('admin.panel.orders.index',
            compact('order', 'userId', 'orderId', 'deliveryTypes', 'paymentTypes', 'orderLogs'));
    }

    public function updateOrderStatus(Request $request, $userId, $orderId)
    {
        $order = OrderModel::findOrFail($orderId);
        $orderStatus = $order->statusOrderSubProduct()->firstOrFail();
        $orderStatus->update($request->all());
    }

    /**
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse
     * update orderIndex and return new orderIndex with new logs
     */
    public function updateOrderIndex(Request $request, $userId, $orderId)
    {
        $oldOrderIndex = OrderModel::findOrFail($orderId);

        $isUpdated = $oldOrderIndex->update($request->all());

        //if orderIndex did not changed return without logs
        if (!$isUpdated) {
            return response()->json($oldOrderIndex);
        }
        //start order logs area
        $newOrderLogs = $oldOrderIndex->orderLogs()
            ->where('created_at', '>=', $oldOrderIndex->updated_at)
            ->with(['logAction', 'author', 'fromto'])
            ->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);

        $oldOrderIndex['order_logs'] = $newOrderLogs;
        //end

        return response()->json($oldOrderIndex);
    }

    /**
     * @param UpdateOrderDeliveryRequest|Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse update orderDelivery
     * update orderDelivery
     * return new orderDelivery with new logs
     */
    public function updateOrderDelivery(UpdateOrderDeliveryRequest $request, $userId, $orderId)
    {
        $oldOrderDelivery = OrderDeliveryModel::findOrFail($request->id);

        $isUpdated = $oldOrderDelivery->update($request->except('delivery_type_id'));

        $deliveryType = DeliveryTypesModel::findOrFail($request->delivery_type_id);
        $oldOrderDelivery->deliveryType()->associate($deliveryType);
        $isOrderDeliveryModified = $oldOrderDelivery->isDirty();
        $oldOrderDelivery->save();

        //if OrderDelivery did not changed return without logs
        $isModified = $isUpdated || $isOrderDeliveryModified;
        if (!$isModified) {
            return response()->json($oldOrderDelivery);
        }

        //start order logs area
        $newOrderLogs = $oldOrderDelivery->orderLogs()
            ->where('created_at', '>=', $oldOrderDelivery->updated_at)
            ->with(['logAction', 'author', 'fromto'])
            ->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);

        $oldOrderDelivery['order_logs'] = $newOrderLogs;
        //end order logs area

        return response()->json($oldOrderDelivery);
    }

    /**
     * @param UpdateContactDetailsRequest|Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse update orderContactDetails
     * update orderContactDetails
     * return new orderContactDetails with new logs
     */
    public function updateOrderContactDetails(UpdateContactDetailsRequest $request, $userId, $orderId)
    {
        $oldOrderContactDetails = OrderContactDetailsModel::findOrFail($request->id);

        $isUpdated = $oldOrderContactDetails->update($request->all());

        //if OrderContactDetails did not changed return without logs
        if (!$isUpdated) {
            return response()->json($oldOrderContactDetails);
        }

        //start order logs area
        $newOrderLogs = $oldOrderContactDetails->orderLogs()
            ->where('created_at', '>=', $oldOrderContactDetails->updated_at)
            ->with(['logAction', 'author', 'fromto'])
            ->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);
        $oldOrderContactDetails['order_logs'] = $newOrderLogs;
        //end

        return response()->json($oldOrderContactDetails);
    }

    /**
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse
     * update orderPayment
     * return new orderPayment with new logs
     */
    public function updateOrderPayment(Request $request, $userId, $orderId)
    {
        $order = OrderModel::findOrFail($orderId);

        $paymentType = PaymentTypesModel::findOrFail($request->payment_type);
        $order->orderPaymentType()->associate($paymentType);
        $isOrderModified = $order->isDirty();
        $order->save();

        //if OrderPayment did not changed return without logs
        if (!$isOrderModified) {
            return response()->json($paymentType);
        }

        $newOrderLogs = $order
            ->orderLogs()
            ->where('created_at', '>=', $order->updated_at)
            ->with(['logAction', 'author', 'fromto'])
            ->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);

        $paymentType['order_logs'] = $newOrderLogs;
        return response()->json($paymentType);
    }

    /**
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse
     * update orderDiscount
     */
    public function updateOrderDiscount(Request $request, $userId, $orderId)
    {

        $order = OrderModel::findOrFail($orderId);

        $oldOrderDiscount = $order->discount()->findOrFail($request->id);

        $oldOrderDiscount->update($request->all());


        return response()->json($oldOrderDiscount);
    }

    /**
     * @param Request $request
     * @param $userId
     * @param $orderId
     * @return JsonResponse
     * update orderBonuses and order totul_sum and user's bonuses
     * return new orderBonuses with new logs
     */
    public function updateOrderBonuses(Request $request, $userId, $orderId)
    {
//        $orderBonuses = OrderBonusesModel::findOrFail($request->id);
        $user = User::findOrFail($userId);
        $order = OrderModel::findOrFail($orderId);
        $orderBonuses = $order->bonuses()->first();


//        //get orderBonuses before update to know bonus_count delta
//        $oldOrderBonuses = $orderBonuses->getOriginal();
        if($orderBonuses) {
            $newBonusCount = $request->bonus_count;

            //set amount of bonus_count change
            $bonusesDelta = $newBonusCount - $orderBonuses->bonus_count;
        } else {
            $orderBonuses = new OrderBonusesModel(['bonus_count' => $request->bonus_count, 'dev_order_index_id' => $order->id]);
            $orderBonuses->save();
            $bonusesDelta = $request->bonus_count;
        }
//        $newBonusCount = $request->bonus_count;
//
//        //set amount of bonus_count change
//        $bonusesDelta = $newBonusCount - $orderBonuses['bonus_count'];

        $newUsersBonuses = $user->bonuses()->firstOrFail();

        //change user's bonuses_amount
        $newUsersBonuses->bonuses_amount -= $bonusesDelta;
        //check if usersBonuses > orderBonuses
        if ($newUsersBonuses->bonuses_amount < 0) {
            $errors = 'Количество бонусов в заказе превышает количество бонусов пользователя';
            return new JsonResponse($errors, 422, [], JSON_UNESCAPED_UNICODE);
        }

        //change order's total_sum
        $order->total_sum -= $bonusesDelta;

        //check if orderTotalSum > orderBonuses
        if ($order->total_sum < 0) {
            $errors = 'Количество бонусов в заказе превышает общую цену в заказе';
            return new JsonResponse($errors, 422, [], JSON_UNESCAPED_UNICODE);
        }
        $isOrderBonusesUpdated = $orderBonuses->update($request->all());

        //if OrderBonuses did not changed return without logs
        if (!$isOrderBonusesUpdated) {
            return response()->json($orderBonuses);
        }

        //change user's bonuses after bonuses changes in order
        $newUsersBonuses->save();

        //change order's total_sum after bonuses changes in order
        $order->save();

        $newOrderLogs = LogOrderModel::where('order_id', $orderId)
            ->where('created_at', '>=', $orderBonuses->updated_at)
            ->with('author', 'logAction', 'fromto')->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);
        $orderBonuses['order_logs'] = $newOrderLogs;

        return response()->json($orderBonuses);
    }


    public function updateOrderBalance(Request $request, $userId, $orderId)
    {
        $user = User::findOrFail($userId);
        $order = OrderModel::findOrFail($orderId);
        $orderBalance = $order->balance()->first();

        if($orderBalance) {
            $newBalanceCount = $request->balance_count;

            //set amount of balance_count change
            $balanceDelta = $newBalanceCount - $orderBalance->balance_count;
        } else {
            $orderBalance = new OrderBalanceModel(['balance_count' => $request->balance_count, 'dev_order_index_id' => $order->id]);
            $orderBalance->save();
            $balanceDelta = $request->balance_count;
        }


        $newUsersBalance = $user->balances()->firstOrFail();

        //change user's balance_amount
        $newUsersBalance->balance_amount -= $balanceDelta;
        //check if usersBalance > orderBalance
        if ($newUsersBalance->balance_amount < 0) {
            $errors = 'Сумма из личного счета в заказе превышает сумму на личном счете пользователя';
            return new JsonResponse($errors, 422, [], JSON_UNESCAPED_UNICODE);
        }

        //change order's total_sum
        $order->total_sum -= $balanceDelta;

        //check if orderTotalSum > orderBalance
        if ($order->total_sum < 0) {
            $errors = 'Сумма из личного счета в заказе превышает общую цену в заказе';
            return new JsonResponse($errors, 422, [], JSON_UNESCAPED_UNICODE);
        }
        $isOrderBalanceUpdated = $orderBalance->update($request->all());

        //if OrderBalance did not changed return without logs
        if (!$isOrderBalanceUpdated) {
            return response()->json($orderBalance);
        }

        //change user's bonuses after balance changes in order
        $newUsersBalance->save();

        //change order's total_sum after balance changes in order
        $order->save();

        $newOrderLogs = LogOrderModel::where('order_id', $orderId)
            ->where('created_at', '>=', $orderBalance->updated_at)
            ->with('author', 'logAction', 'fromto')->get();

        //Change loggable_type and field_changed to user friendly
        $this->changeToRussianNames($newOrderLogs);
        $orderBalance['order_logs'] = $newOrderLogs;

        return response()->json($orderBalance);
    }
    /**
     * @param $model
     * @return string
     * change loggable_type to russian name
     */
    private function getRussianModelName($model)
    {
        switch ($model) {
            case (OrderBonusesModel::class):
                return 'Бонусов';
                break;
            case (OrderContactDetailsModel::class):
                return 'Контактной инфрмации';
                break;
            case (OrderDeliveryModel::class):
                return 'Доставки';
                break;
            case (OrderModel::class):
                return 'Общей информации';
                break;
            case (OrderBalanceModel::class):
                return 'Личного счета';
                break;
        }
    }

    /**
     * @param $field
     * @return string
     * change field_changed to russian name
     */
    private function getRussianFieldName($field)
    {
        switch ($field) {
            case ('payment_type_id'):
                return 'тип оплаты';
                break;
            case ('payment_type'):
                return 'тип оплаты';
                break;
            case ('delivery_type_id'):
                return 'тип доставки';
                break;
            case ('l_name'):
                return 'фамилия';
                break;
            case ('delivery_l_name'):
                return 'фамилия';
                break;
            case ('f_name'):
                return 'имя';
                break;
            case ('delivery_f_name'):
                return 'имя';
                break;
            case ('city'):
                return 'город';
                break;
            case ('cell'):
                return 'телефон';
                break;
            case ('delivery_phone'):
                return 'телефон';
                break;
            case ('delivery_address'):
                return 'адресс';
                break;
            case ('public_order_id'):
                return 'номер';
                break;
            case ('total_sum'):
                return 'общая сумма';
                break;
            case ('total_quantity'):
                return 'общее количество';
                break;
            case ('comment'):
                return 'комментарий';
                break;
            case ('discount_amount'):
                return 'Величина скидки';
                break;
            case ('active_from'):
                return 'активна от';
                break;
            case ('active_to'):
                return 'активна до';
                break;
            case ('status'):
                return 'статус';
                break;
            case ('bonus_count'):
                return 'количество бонусов';
                break;
            case ('balance_count'):
                return 'количество из личного счета';
                break;
            default:
                return $field;
        }
    }

    /**
     * @param $newOrderLogs
     * change logs to russian names
     */
    private function changeToRussianNames($newOrderLogs)
    {
        foreach ($newOrderLogs as $newOrderLog) {
            $newOrderLog['loggable_type'] = $this->getRussianModelName($newOrderLog['loggable_type']);
            $newOrderLog['field_changed'] = $this->getRussianFieldName($newOrderLog['field_changed']);
        }
    }
}
