<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use App\Contracts\Orders\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Product\CancelOrder as CancelOrderAction;

class CancelOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Instance of order.
     *
     * @var \App\Contracts\Orders\Order
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param \App\Contracts\Orders\Order $order
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
        try {
            $action->cancel($this->order);
        } catch (Throwable $e) {
            $this->fail($e);
        }
    }
}
