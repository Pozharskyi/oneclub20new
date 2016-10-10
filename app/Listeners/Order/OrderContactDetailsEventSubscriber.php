<?php


namespace App\Listeners\Order;


use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogOrderModel;

class OrderContactDetailsEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function orderContactDetailsBeforeUpdate($orderContactDetails)
    {

        //save $orderIndex before update
        self::$original = $orderContactDetails->getOriginal();

        //get $orderIndex attributes
        $attributes = $orderContactDetails->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($orderContactDetails->isDirty($k)) {
                array_push(self::$dirtyFields, $k);
            }
        }
    }

    /**
     * Handle user updated events.
     * @param $orderContactDetails
     * @internal param $orderIndex
     * @internal param $user
     */
    public function orderContactDetailsUpdated($orderContactDetails)
    {
        $attributes = $orderContactDetails->getAttributes();

        $logFromToStrings = [];

        //save changed attributes in  dev_log_from_to_string tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => self::$original[$attribute], 'to' => $orderContactDetails->getAttribute($attribute)]);
                $logFromToStrings[$attribute]->save();

                $userLog = $this->createOrderLogInstance($orderContactDetails);
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
            'App\Events\Order\OrderContactDetailsBeforeUpdate',
            'App\Listeners\Order\OrderContactDetailsEventSubscriber@orderContactDetailsBeforeUpdate'
        );

        $events->listen(
            'App\Events\Order\OrderContactDetailsUpdated',
            'App\Listeners\Order\OrderContactDetailsEventSubscriber@orderContactDetailsUpdated'
        );
    }

    /**
     * @param $orderContactDetails
     * @return LogOrderModel
     * @internal param $orderIndex
     * @internal param $user
     */
    private function createOrderLogInstance($orderContactDetails)
    {
        $orderLog = new LogOrderModel();
        $orderLog->author_id = \Auth::id();
        $orderLog->action_id = 2;
        $orderLog->date = $orderContactDetails->updated_at;
        $orderLog->order_id = $orderContactDetails->order_id;

        $orderLog->loggable()->associate($orderContactDetails);
        return $orderLog;
    }
}