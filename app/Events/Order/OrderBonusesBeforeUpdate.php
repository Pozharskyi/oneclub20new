<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderBonusesBeforeUpdate
{
    use InteractsWithSockets, SerializesModels;

    protected $orderBonuses;
    /**
     * Create a new event instance.
     *
     * @param $orderBonuses
     */
    public function __construct($orderBonuses)
    {
        $this->orderBonuses = $orderBonuses;
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
