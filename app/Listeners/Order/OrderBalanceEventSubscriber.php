<?php


namespace App\Listeners\Order;


use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogOrderModel;

class OrderBalanceEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function orderBalanceBeforeUpdate($orderBalance)
    {

        //save $orderIndex before update
        self::$original = $orderBalance->getOriginal();

        //get $orderIndex attributes
        $attributes = $orderBalance->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($orderBalance->isDirty($k)) {
                array_push(self::$dirtyFields, $k);
            }
        }
    }

    /**
     * Handle user updated events.
     * @param $orderBalance
     */
    public function orderBalanceUpdated($orderBalance)
    {
        $attributes = $orderBalance->getAttributes();

        $logFromToInt = [];

        //save changed attributes in  dev_log_from_to_int tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                $logFromToInt[$attribute] = new LogFromToIntModel([
                    'from' => self::$original[$attribute],
                    'to' => $orderBalance->getAttribute($attribute)
                ]);

                $logFromToInt[$attribute]->save();

                $userLog = $this->createOrderLogInstance($orderBalance);
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
            'App\Events\Order\OrderBalanceBeforeUpdate',
            'App\Listeners\Order\OrderBalanceEventSubscriber@orderBalanceBeforeUpdate'
        );

        $events->listen(
            'App\Events\Order\OrderBalanceUpdated',
            'App\Listeners\Order\OrderBalanceEventSubscriber@orderBalanceUpdated'
        );
    }

    /**
     * @param $orderBalance
     * @return LogOrderModel
     */
    private function createOrderLogInstance($orderBalance)
    {
        $orderLog = new LogOrderModel();
        $orderLog->author_id = \Auth::id();
        $orderLog->action_id = 2;
        $orderLog->date = $orderBalance->updated_at;
        $orderLog->order_id = $orderBalance->dev_order_index_id;

        $orderLog->loggable()->associate($orderBalance);
        return $orderLog;
    }
}