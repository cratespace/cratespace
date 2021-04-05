<?php

namespace App\Events;

use App\Contracts\Billing\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The product instance.
     *
     * @var \App\Contracts\Billing\Product
     */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Billing\Product|null
     *
     * @return void
     */
    public function __construct(?Product $product = null)
    {
        $this->product = $product;
    }
}
