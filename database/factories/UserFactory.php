<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Str;
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
            'settings' => [],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ];
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return \Database\Factories\UserFactory
     */
    public function withBusiness(): UserFactory
    {
        return $this->has(
            Business::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'name' => $this->faker->unique()->company,
                        'user_id' => $user->id,
                        'credit' => 0,
                    ];
                }),
            'business'
        );
    }
}
