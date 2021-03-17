<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use App\Contracts\Purchases\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Orders\CancelOrder as CancelOrderAction;

class CancelOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Instance of order.
     *
     * @var \App\Contracts\Purchases\Order
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param \App\Contracts\Purchases\Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CancelOrderAction $action)
    {
        $action->cancel($this->order);
    }
}
