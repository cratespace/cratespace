<?php

namespace Database\Factories;

use App\Models\Product;
use Tests\Fixtures\MockProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = new MockProduct('test_product');

        return [
            'code' => $product->code(),
            'productable_id' => $product->id,
            'productable_type' => get_class($product),
        ];
    }
}
