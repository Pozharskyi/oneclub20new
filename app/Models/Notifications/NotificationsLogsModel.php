<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationsLogsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_notifications_logs';

    /**
     * Getting user
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getUser()
    {
        return $this->hasOne( 'App\User', 'id', 'user_id' );
    }

    /**
     * Getting event
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getNotification()
    {
        return $this->hasOne( 'App\Models\Notifications\NotificationsModel', 'id', 'event_id' );
    }
}
