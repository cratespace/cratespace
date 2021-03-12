<?php

namespace App\Events;

use App\Models\Space;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class SpaceEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Instance of Space being managed.
     *
     * @var \App\Models\Space
     */
    public $space;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function __construct(Space $space)
    {
        $this->space = $space;
    }
}
