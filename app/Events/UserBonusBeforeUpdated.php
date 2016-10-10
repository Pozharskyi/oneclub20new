<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserBonusBeforeUpdated
{
    use InteractsWithSockets, SerializesModels;

    protected $userBonus;
    /**
     * Create a new event instance.
     *
     * @param $userBonus
     */
    public function __construct($userBonus)
    {
        $this->userBonus = $userBonus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
