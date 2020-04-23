<?php

namespace App\Events;

<<<<<<< HEAD
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadReceivedNewReply
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
=======
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadReceivedNewReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

    /**
     * The reply instance.
     *
     * @var \App\Models\Reply
     */
<<<<<<< HEAD
    protected $reply;
=======
    public $reply;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

    /**
     * Create a new event instance.
     *
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
<<<<<<< HEAD

    /**
     * Get reply instance.
     *
     * @return \App\Models\Reply
     */
    public function getReply()
    {
        return $this->reply;
    }
=======
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
}
