<?php


namespace App\Listeners\Order;


use App\Models\Discount\DiscountsModel;
use App\Models\Loging\LogFromToDecimalModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogOrderModel;
use App\Models\Payment\PaymentTypesModel;

class OrderIndexEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function orderIndexBeforeUpdated($orderIndex)
    {

        //save $orderIndex before update
        self::$original = $orderIndex->getOriginal();

        //get $orderIndex attributes
        $attributes = $orderIndex->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($orderIndex->isDirty($k)) {
                array_push(self::$dirtyFields, $k);
            }
        }
    }

    /**
     * Handle user updated events.
     * @param $orderIndex
     * @internal param $user
     */
    public function orderIndexUpdated($orderIndex)
    {
        $attributes = $orderIndex->getAttributes();


        $logFromToDecimals = [];
        $logFromToStrings = [];

        //save changed attributes in one of dev_log_from_to_int or dev_log_from_to_string tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                if ($attribute == "total_quantity" || $attribute == 'total_sum') {
                    $logFromToDecimals[$attribute] = new LogFromToDecimalModel(['from' => self::$original[$attribute], 'to' => $orderIndex->getAttribute($attribute)]);
                    $logFromToDecimals[$attribute]->save();

                    $orderLog = $this->createOrderLogInstance($orderIndex);
                    $orderLog->field_changed = $attribute;

                    $logFromToDecimals[$attribute]->orderLogs()->save($orderLog);
                } else {
                    // save in dev_log_from_to_string table value of payment_type
                    if ($attribute == "payment_type_id") {
                        $oldPaymentType = PaymentTypesModel::findOrFail(self::$original[$attribute]);
                        $from = $oldPaymentType->payment_type;
                        $newPaymentType = PaymentTypesModel::findOrFail($orderIndex->getAttribute($attribute));
                        $to = $newPaymentType->payment_type;

                    } elseif($attribute == "discount_id"){
                        $newDiscount = DiscountsModel::findOrFail($orderIndex->getAttribute($attribute));
                        $to = $newDiscount->discount_id;
                        if(self::$original[$attribute] == null){
                            $from = null;

                        } else{
                            $oldDiscount = DiscountsModel::findOrFail(self::$original[$attribute]);
                            $from = $oldDiscount->discount_id;
                        }
                    } else {
                        $from = self::$original[$attribute];
                        $to = $orderIndex->getAttribute($attribute);
                    }
                    $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => $from, 'to' => $to]);

                    $logFromToStrings[$attribute]->save();

                    $userLog = $this->createOrderLogInstance($orderIndex);
                    $userLog->field_changed = $attribute;

                    $logFromToStrings[$attribute]->userLogs()->save($userLog);

                }

            }
        }

    }

    /**
     * Register the listeners for the subscriber.
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Order\OrderIndexBeforeUpdated',
            'App\Listeners\Order\OrderIndexEventSubscriber@orderIndexBeforeUpdated'
        );

        $events->listen(
            'App\Events\Order\OrderIndexUpdated',
            'App\Listeners\Order\OrderIndexEventSubscriber@orderIndexUpdated'
        );
    }

    /**
     * @param $orderIndex
     * @return LogOrderModel
     * @internal param $user
     */
    public function createOrderLogInstance($orderIndex)
    {
        $orderLog = new LogOrderModel();
        $orderLog->author_id = \Auth::id();
        $orderLog->action_id = 2;
        $orderLog->date = $orderIndex->updated_at;
        $orderLog->order_id = $orderIndex->id;

        $orderLog->loggable()->associate($orderIndex);
        return $orderLog;
    }
}