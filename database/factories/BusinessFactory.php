<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $business = $this->faker->unique()->company;

        return [
            'name' => $business,
            'slug' => Str::slug($business),
            'description' => $this->faker->paragraph(3),
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'postcode' => $this->faker->postcode,
            'user_id' => create(User::class),
        ];
    }
}
