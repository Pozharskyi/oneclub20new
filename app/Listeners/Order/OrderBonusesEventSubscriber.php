<?php


namespace App\Listeners\Order;


use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogOrderModel;

class OrderBonusesEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function orderBonusesBeforeUpdate($orderBonuses)
    {

        //save $orderIndex before update
        self::$original = $orderBonuses->getOriginal();

        //get $orderIndex attributes
        $attributes = $orderBonuses->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($orderBonuses->isDirty($k)) {
                array_push(self::$dirtyFields, $k);
            }
        }
    }

    /**
     * Handle user updated events.
     * @param $orderBonuses
     * @internal param $orderContactDetails
     * @internal param $orderIndex
     * @internal param $user
     */
    public function orderBonusesUpdated($orderBonuses)
    {
        $attributes = $orderBonuses->getAttributes();

        $logFromToInt = [];

        //save changed attributes in  dev_log_from_to_int tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                $logFromToInt[$attribute] = new LogFromToIntModel([
                    'from' => self::$original[$attribute],
                    'to' => $orderBonuses->getAttribute($attribute)
                ]);

                $logFromToInt[$attribute]->save();

                $userLog = $this->createOrderLogInstance($orderBonuses);
                $userLog->field_changed = $attribute;

                $logFromToInt[$attribute]->userLogs()->save($userLog);

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
            'App\Events\Order\OrderBonusesBeforeUpdate',
            'App\Listeners\Order\OrderBonusesEventSubscriber@orderBonusesBeforeUpdate'
        );

        $events->listen(
            'App\Events\Order\OrderBonusesUpdated',
            'App\Listeners\Order\OrderBonusesEventSubscriber@orderBonusesUpdated'
        );
    }

    /**
     * @param $orderBonuses
     * @return LogOrderModel
     * @internal param $orderContactDetails
     * @internal param $orderIndex
     * @internal param $user
     */
    private function createOrderLogInstance($orderBonuses)
    {
        $orderLog = new LogOrderModel();
        $orderLog->author_id = \Auth::id();
        $orderLog->action_id = 2;
        $orderLog->date = $orderBonuses->updated_at;
        $orderLog->order_id = $orderBonuses->dev_order_index_id;

        $orderLog->loggable()->associate($orderBonuses);
        return $orderLog;
    }
}