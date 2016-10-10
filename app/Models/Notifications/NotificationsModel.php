<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsModel extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_notifications_index';

    protected $fillable = [
        'notification_id', 'notification_type_id',
        'notification_request_message', 'notification_params',
    ];

    /**
     * Getting notification list
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getNotificationList()
    {
        return $this->hasOne(NotificationsListModel::class, 'id', 'notification_id' );
    }

    /**
     * Getting notification type
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getNotificationType()
    {
        return $this->hasOne(NotificationsTypeModel::class, 'id', 'notification_type_id' );
    }
}
