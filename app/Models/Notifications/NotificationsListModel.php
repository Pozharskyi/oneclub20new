<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationsListModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_notifications_list';

    protected $fillable = ['notification'];
    /**
     * Getting notifications
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getNotifications()
    {
        return $this->hasMany(NotificationsModel::class, 'notification_id' );
    }
}
