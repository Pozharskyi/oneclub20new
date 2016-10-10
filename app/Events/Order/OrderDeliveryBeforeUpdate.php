<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderDeliveryBeforeUpdate
{
    use InteractsWithSockets, SerializesModels;

    protected $orderDelivery;
    /**
     * Create a new event instance.
     *
     * @param $orderDelivery
     */
    public function __construct($orderDelivery)
    {
        $this->orderDelivery = $orderDelivery;
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
