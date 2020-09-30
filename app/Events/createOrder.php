<?php

namespace App\Events;

use App\Order;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class createOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
   public $user, $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order)
    {
        $this->user=$user;
        $this->order=$order;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order.' . $this->user->id);
    }
    public function broadcastAs()
    {
        return 'createOrder';
    }
}
