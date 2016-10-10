<?php


namespace App\Listeners;


use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogUserModel;

class UserBalanceEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function userBalanceBeforeUpdated($userBalance)
    {

        //save userBonus before update
        self::$original = $userBalance->getOriginal();

        //get userBonus attributes
        $attributes = $userBalance->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($userBalance->isDirty($k)){
                array_push(self::$dirtyFields, $k);
            }

        }
    }

    /**
     * Handle user updated events.
     * @param $userBalance
     */
    public function userBalanceUpdated($userBalance)
    {
        $attributes = $userBalance->getAttributes();


        $logFromToInts = [];

        //save changed attributes in one of dev_log_from_to_int
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                if ($attribute == "balance_amount") {
                    $logFromToInts[$attribute] = new LogFromToIntModel(['from' => (int)self::$original[$attribute], 'to' => $userBalance->getAttribute($attribute)]);
                    $logFromToInts[$attribute]->save();

                    $userLog = $this->createUserLogInstance($userBalance);
                    $userLog->field_changed = $attribute;

                    $logFromToInts[$attribute]->userLogs()->save($userLog);

                }
                if($attribute == "balance_comment") {
                    $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => self::$original[$attribute], 'to' => $userBalance->getAttribute($attribute)]);
                    $logFromToStrings[$attribute]->save();

                    $userLog = $this->createUserLogInstance($userBalance);
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
            'App\Events\UserBalanceUpdated',
            'App\Listeners\UserBalanceEventSubscriber@userBalanceUpdated'
        );

        $events->listen(
            'App\Events\UserBalanceBeforeUpdated',
            'App\Listeners\UserBalanceEventSubscriber@userBalanceBeforeUpdated'
        );
    }

    /**
     * @param $userBalance
     * @return LogUserModel
     */
    private function createUserLogInstance($userBalance)
    {
        $userLog = new LogUserModel();
        $userLog->author_id = \Auth::id();
        $userLog->user_id = $userBalance->user_id;
        $userLog->action_id = 2;
        $userLog->date = $userBalance->updated_at;
        return $userLog;
    }
}