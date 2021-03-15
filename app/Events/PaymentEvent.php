<?php

namespace App\Events;

use App\Models\Charge;
use App\Models\Business;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PaymentEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The instance of the charge.
     *
     * @var \App\Models\Charge
     */
    public $charge;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Charge $charge
     *
     * @return void
     */
    public function __construct(Charge $charge)
    {
        $this->charge = $charge;
    }

    /**
     * Get the business the charge was made for.
     *
     * @return \App\Models\Business
     */
    public function business(): Business
    {
        return $this->charge->user->business;
    }
}
