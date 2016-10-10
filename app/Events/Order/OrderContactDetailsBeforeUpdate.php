<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderContactDetailsBeforeUpdate
{
    use InteractsWithSockets, SerializesModels;

    protected $orderContactDetails;

    /**
     * Create a new event instance.
     *
     * @param $orderContactDetails
     * @internal param $orderDescription
     */
    public function __construct($orderContactDetails)
    {
        $this->orderContactDetails = $orderContactDetails;
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
