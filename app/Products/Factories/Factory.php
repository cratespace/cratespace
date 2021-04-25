<?php

namespace App\Products\Factories;

use App\Models\User;
use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Auth;
use App\Support\Concerns\InteractsWithContainer;

abstract class Factory
{
    use InteractsWithContainer;

    /**
     * The insrtance of the product being manufactured.
     *
     * @var \App\Contracts\Products\Product|null
     */
    protected $product;

    /**
     * The product the fatory manufactures.
     *
     * @var string
     */
    protected $merchandise;

    /**
     * Create new product.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    abstract public function make(array $data = []): Product;

    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Get the instance of the product being manufactured.
     *
     * @param array[] $parameters
     *
     * @return \App\Contracts\Products\Product
     */
    public function getProductInstance(array $parameters = []): Product
    {
        if (is_null($this->product)) {
            $this->product = $this->resolve($this->merchandise, $parameters);
        }

        return $this->product;
    }
}
