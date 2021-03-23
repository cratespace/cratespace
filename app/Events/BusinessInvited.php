<?php

namespace App\Events;

use App\Models\Invitation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BusinessInvited
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The business invitation instance.
     *
     * @var \App\Models\Invitation
     */
    public $invitation;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Invitation $invitation
     *
     * @return void
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }
}
