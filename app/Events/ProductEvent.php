<?php

namespace App\Events;

use App\Contracts\Products\Product;
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
     * @var \App\Contracts\Products\Product
     */
    protected $product;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Products\Product $product
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
