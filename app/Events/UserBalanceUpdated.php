<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserBalanceUpdated
{
    use InteractsWithSockets, SerializesModels;

    protected $userBalance;

    /**
     * Create a new event instance.
     *
     * @param $userBalance
     */
    public function __construct($userBalance)
    {
        $this->userBalance = $userBalance;

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
