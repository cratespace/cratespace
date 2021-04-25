<?php

namespace App\Products\Factories;

use App\Products\Products\Space;
use App\Support\Traits\Fillable;
use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Crypt;

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

        abort_unless($this->user()->isResponsibleFor($product), 403);

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
