<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentProcessingSucceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user from whom the resource was purchased.
     *
     * @param \App\Models\User $user
     */
    public $user;

    /**
     * The amount credited to the user's business.
     *
     * @var int
     */
    public $credit;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param int $credit
     */
    public function __construct(User $user, int $credit)
    {
        $this->user = $user;
        $this->credit = $credit;
    }

    /**
     * Get the subject of the event.
     */
    public function subject()
    {
        $this->user;
        $this->credit;
    }
}
