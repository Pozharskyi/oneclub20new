<?php


namespace App\Listeners\Order;


use App\Models\Delivery\DeliveryTypesModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogOrderModel;

class OrderDeliveryEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function orderDeliveryBeforeUpdate($orderDelivery)
    {

        //save $orderIndex before update
        self::$original = $orderDelivery->getOriginal();

        //get $orderIndex attributes
        $attributes = $orderDelivery->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($orderDelivery->isDirty($k)) {
                array_push(self::$dirtyFields, $k);
            }
        }
    }

    /**
     * Handle user updated events.
     * @param $orderDelivery
     * @internal param $orderContactDetails
     * @internal param $orderIndex
     * @internal param $user
     */
    public function orderDeliveryUpdated($orderDelivery)
    {
        $attributes = $orderDelivery->getAttributes();

        $logFromToStrings = [];

        //save changed attributes in  dev_log_from_to_string tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                // save in dev_log_from_to_string table value of delivery_type
                if ($attribute == "delivery_type_id") {
                    $oldPaymentType = DeliveryTypesModel::findOrFail(self::$original[$attribute]);
                    $from = $oldPaymentType->delivery_type;
                    $newPaymentType = DeliveryTypesModel::findOrFail($orderDelivery->getAttribute($attribute));
                    $to = $newPaymentType->delivery_type;

                } else {
                    $from = self::$original[$attribute];
                    $to = $orderDelivery->getAttribute($attribute);
                }
                $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => $from, 'to' => $to]);

                $logFromToStrings[$attribute]->save();

                $userLog = $this->createOrderLogInstance($orderDelivery);
                $userLog->field_changed = $attribute;

                $logFromToStrings[$attribute]->userLogs()->save($userLog);

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
            'App\Events\Order\OrderDeliveryBeforeUpdate',
            'App\Listeners\Order\OrderDeliveryEventSubscriber@orderDeliveryBeforeUpdate'
        );

        $events->listen(
            'App\Events\Order\OrderDeliveryUpdated',
            'App\Listeners\Order\OrderDeliveryEventSubscriber@orderDeliveryUpdated'
        );
    }

    /**
     * @param $orderDelivery
     * @return LogOrderModel
     * @internal param $orderContactDetails
     * @internal param $orderIndex
     * @internal param $user
     */
    private function createOrderLogInstance($orderDelivery)
    {
        $orderLog = new LogOrderModel();
        $orderLog->author_id = \Auth::id();
        $orderLog->action_id = 2;
        $orderLog->date = $orderDelivery->updated_at;
        $orderLog->order_id = $orderDelivery->order_id;

        $orderLog->loggable()->associate($orderDelivery);
        return $orderLog;
    }
}