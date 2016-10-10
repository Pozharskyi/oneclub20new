<?php
namespace App\Listeners;


use App\Models\Loging\LogFromToDataModel;
use App\Models\Loging\LogFromToIntModel;
use App\Models\Loging\LogFromToStringModel;
use App\Models\Loging\LogUserModel;
use App\User;

use Carbon\Carbon;

class UserEventSubscriber
{
    protected static $original;
    protected static $dirtyFields = [];

    public function userBeforeUpdated($user)
    {

        //save user before update
        self::$original = $user->getOriginal();

        //get users attributes
        $attributes = $user->getAttributes();

        //save attributes that was modified
        foreach ($attributes as $k => $v) {
            if ($user->isDirty($k)){
                array_push(self::$dirtyFields, $k);
            }

        }
    }

    /**
     * Handle user updated events.
     * @param $user
     */
    public function userUpdated($user)
    {
        $attributes = $user->getAttributes();


        $logFromToInts = [];
        $logFromToStrings = [];
        $logFromToDatas = [];

        //save changed attributes in one of dev_log_from_to_int or dev_log_from_to_string or dev_log_from_to_data tables
        foreach ($attributes as $attribute => $v) {
            if (in_array($attribute, self::$dirtyFields)) {

                if ($attribute == "phone") {
                    $logFromToInts[$attribute] = new LogFromToIntModel(['from' => (int)self::$original[$attribute], 'to' => (int)$user->getAttribute($attribute)]);
                    $logFromToInts[$attribute]->save();

                    $userLog = $this->createUserLogInstance($user);
                    $userLog->field_changed = $attribute;

                    $logFromToInts[$attribute]->userLogs()->save($userLog);

                } elseif ($attribute == "date_of_birth") {
                    $logFromToDatas[$attribute] = new LogFromToDataModel(['from' => self::$original[$attribute], 'to' => $user->getAttribute($attribute)]);
                    $logFromToDatas[$attribute]->save();

                    $userLog = $this->createUserLogInstance($user);
                    $userLog->field_changed = $attribute;

                    $logFromToDatas[$attribute]->userLogs()->save($userLog);
                } else {
                    $logFromToStrings[$attribute] = new LogFromToStringModel(['from' => self::$original[$attribute], 'to' => $user->getAttribute($attribute)]);
                    $logFromToStrings[$attribute]->save();

                    $userLog = $this->createUserLogInstance($user);
                    $userLog->field_changed = $attribute;

                    $logFromToStrings[$attribute]->userLogs()->save($userLog);

                }

            }
        }

    }

    public function userDeleted($user)
    {
        $userLog = new LogUserModel();
        $userLog->author_id = \Auth::id();
        $userLog->user_id = $user->id;
        $userLog->action_id = 3;
        $userLog->date = Carbon::now();
        $userLog->save();
    }

    /**
     * @param $user
     */
    public function userCreated($user)
    {
        $userLog = new LogUserModel();
        $userLog->author_id = $user->id;
        $userLog->user_id = $user->id;
        $userLog->action_id = 1;
        $userLog->date = $user->created_at;
        $userLog->save();
    }


    /**
     * Register the listeners for the subscriber.
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\UserUpdated',
            'App\Listeners\UserEventSubscriber@userUpdated'
        );

        $events->listen(
            'App\Events\UserBeforeUpdated',
            'App\Listeners\UserEventSubscriber@userBeforeUpdated'
        );
        $events->listen(
            'App\Events\UserDeleted',
            'App\Listeners\UserEventSubscriber@userDeleted'
        );
        $events->listen(
            'App\Events\UserCreated',
            'App\Listeners\UserEventSubscriber@userCreated'
        );
    }

    /**
     * @param $user
     * @return LogUserModel
     */
    private function createUserLogInstance($user)
    {
        $userLog = new LogUserModel();
        $userLog->author_id = \Auth::id();
        $userLog->user_id = $user->id;
        $userLog->action_id = 2;
        $userLog->date = $user->updated_at;
        return $userLog;
    }

}