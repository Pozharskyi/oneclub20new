<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationsTypeModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dev_notifications_types_list';

    protected $fillable = ['notifications_type'];
    /**
     * Getting notification
     * Based on notification
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getNotification()
    {
        return $this->hasMany(NotificationsModel::class, 'notification_type_id' );
    }

    public function scopeWithEvent( $query, $event_id )
    {
        $query->leftJoin('dev_notifications_index', function( $join ) use ( $event_id )
        {
            $join->on('dev_notifications_index.notification_type_id', '=', 'dev_notifications_types_list.id')
                ->where('dev_notifications_index.notification_id', '=', $event_id);
        });
    }
}
