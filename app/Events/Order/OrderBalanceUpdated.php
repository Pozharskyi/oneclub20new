<?php

namespace App\Events\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderBalanceUpdated
{
    use InteractsWithSockets, SerializesModels;

    protected $orderBalance;

    /**
     * Create a new event instance.
     *
     * @param $orderBalance
     */
    public function __construct($orderBalance)
    {
        $this->orderBalance = $orderBalance;
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
