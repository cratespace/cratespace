<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Actions\Business\MakeNewPayout;

class MakePayout
{
    /**
     * The payout calculator instance.
     *
     * @var \App\Actions\Business\MakeNewPayout
     */
    protected $payoutMaker;

    /**
     * Create new instance of payout maker action class.
     *
     * @param \App\Actions\Business\MakeNewPayout $maker
     *
     * @return void
     */
    public function __construct(MakeNewPayout $payoutMaker)
    {
        $this->payoutMaker = $payoutMaker;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\PaymentSuccessful $event
     *
     * @return void
     */
    public function handle(PaymentSuccessful $event)
    {
        $this->payoutMaker->make($event->business(), $event->payment);
    }
}
