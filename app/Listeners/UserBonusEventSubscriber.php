<?php


namespace App\Listeners;


use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogUserModel;

class UserBonusEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function userBonusBeforeUpdated($userBonus)
    {

        //save userBonus before update
        self::$original = $userBonus->getOriginal();

        //get userBonus attributes
        $attributes = $userBonus->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($userBonus->isDirty($k)){
                array_push(self::$dirtyFields, $k);
            }

        }
    }

    /**
     * Handle user updated events.
     * @param $userBonus
     * @internal param $user
     */
    public function userBonusUpdated($userBonus)
    {
        $attributes = $userBonus->getAttributes();


        $logFromToInts = [];
        $logFromToStrings = [];

        //save changed attributes in one of dev_log_from_to_int or dev_log_from_to_string or dev_log_from_to_data tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                if ($attribute == "bonuses_amount") {
                    $logFromToInts[$attribute] = new LogFromToIntModel(['from' => (int)self::$original[$attribute], 'to' => (int)$userBonus->getAttribute($attribute)]);
                    $logFromToInts[$attribute]->save();

                    $userLog = $this->createUserLogInstance($userBonus);
                    $userLog->field_changed = $attribute;

                    $logFromToInts[$attribute]->userLogs()->save($userLog);
                }

                if($attribute == "bonuses_comment") {
                    $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => self::$original[$attribute], 'to' => $userBonus->getAttribute($attribute)]);
                    $logFromToStrings[$attribute]->save();

                    $userLog = $this->createUserLogInstance($userBonus);
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
            'App\Events\UserBonusUpdated',
            'App\Listeners\UserBonusEventSubscriber@userBonusUpdated'
        );

        $events->listen(
            'App\Events\UserBonusBeforeUpdated',
            'App\Listeners\UserBonusEventSubscriber@userBonusBeforeUpdated'
        );
    }

    /**
     * @param $userBonus
     * @return LogUserModel
     * @internal param $user
     */
    private function createUserLogInstance($userBonus)
    {
        $userLog = new LogUserModel();
        $userLog->author_id = \Auth::id();
        $userLog->user_id = $userBonus->user_id;
        $userLog->action_id = 2;
        $userLog->date = $userBonus->updated_at;
        return $userLog;
    }
}