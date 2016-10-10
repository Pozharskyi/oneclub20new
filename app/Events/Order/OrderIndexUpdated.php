<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderIndexUpdated
{
    use InteractsWithSockets, SerializesModels;

    protected $orderIndex;

    /**
     * Create a new event instance.
     *
     * @param $orderIndex
     */
    public function __construct($orderIndex)
    {
        $this->orderIndex = $orderIndex;
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
