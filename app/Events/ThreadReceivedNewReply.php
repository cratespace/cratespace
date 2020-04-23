<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadReceivedNewReply
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The reply instance.
     *
     * @var \App\Models\Reply
     */
    protected $reply;

    /**
     * Create a new event instance.
     *
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get reply instance.
     *
     * @return \App\Models\Reply
     */
    public function getReply()
    {
        return $this->reply;
    }
}
