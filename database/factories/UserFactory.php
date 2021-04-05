<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Business;
use App\Models\Customer;
use Illuminate\Support\Str;
use Cratespace\Preflight\Models\Role;
use App\Services\Stripe\Customer as StripeCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'settings' => [
                'notifications' => ['mail', 'database'],
            ],
            'address' => [
                'line1' => $this->faker->streetName,
                'city' => $this->faker->city,
                'state' => $this->faker->state,
                'country' => $this->faker->country,
                'postal_code' => $this->faker->postcode,
            ],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ];
    }

    /**
     * Create a business profile for the user.
     *
     * @return \Database\Factories\UserFactory
     */
    public function asBusiness(): UserFactory
    {
        return $this->has(
            Business::factory()
                ->state(function (array $attributes, User $user) {
                    $user->assignRole(
                        Role::firstOrCreate(['name' => 'Business', 'slug' => 'business'])
                    );

                    return ['user_id' => $user->id];
                }),
            'business'
        );
    }

    /**
     * Create a customer profile for the user.
     *
     * @return \Database\Factories\UserFactory
     */
    public function asCustomer(): UserFactory
    {
        return $this->has(
            Customer::factory()
                ->state(function (array $attributes, User $user) {
                    $customer = StripeCustomer::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ]);

                    $user->assignRole(
                        Role::firstOrCreate(['name' => 'Customer', 'slug' => 'customer'])
                    );

                    return [
                        'stripe_id' => $customer->id,
                        'user_id' => $user->id,
                    ];
                }),
            'customer'
        );
    }
}
