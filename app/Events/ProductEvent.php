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

    public $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
