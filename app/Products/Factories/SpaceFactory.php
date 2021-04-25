<?php

namespace App\Products\Factories;

use App\Products\Products\Space;
use App\Support\Traits\Fillable;
use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Access\AuthorizationException;

class SpaceFactory extends Factory
{
    use Fillable;

    /**
     * The product the fatory manufactures.
     *
     * @var string
     */
    protected $merchandise = Space::class;

    /**
     * Create new product instance.
     *
     * @param array $data
     *
     * @return \App\Contracts\Products\Product
     */
    public function make(array $data = []): Product
    {
        $product = $this->getProductInstance();

        if (! $this->user()->isResponsibleFor($product)) {
            throw new AuthorizationException('User is not authorized to perform this action');
        }

        return tap($product->create(
            array_merge($this->parse($data), $this->options())
        ), function (Product $product): void {
            $product->setCode(Crypt::encrypt(
                get_class($product) . '-' . $product->name()
            ));

            $this->product = $product;
        });
    }

    /**
     * Get the default options used when manufacturing a new product.
     *
     * @param array $overrides
     *
     * @return array
     */
    protected function options(array $overrides = []): array
    {
        return array_merge([
            'user_id' => $this->user()->id,
            'base' => $this->user()->base(),
        ], $overrides);
    }

    /**
     * Parse the data array, filtering out unnecessary data.
     *
     * @param array $data
     *
     * @return array
     */
    public function parse(array $data): array
    {
        return $this->filterFillable($this->merchandise, $data);
    }
}
