<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableUser;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Default role to be assigned to the user.
     *
     * @var string
     */
    protected $role = 'Business';

    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data): AuthenticatableUser
    {
        return tap($this->createUser($data), function (User $user) {
            return $user->fresh();
        });
    }

    /**
     * Create new user profile.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    protected function createUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $this->makeUsername($data['name']),
            'password' => Hash::make($data['password']),
            'profile' => $this->createUserProfile($data),
            'address' => $this->createAddress($data),
            'settings' => $this->setDefaultSettings(),
        ]);

        $user->assignRole($this->role);

        return $user;
    }

    /**
     * Create a profile for the user.
     *
     * @param array $data
     *
     * @return array
     */
    protected function createUserProfile(array $data): array
    {
        if ($data['type'] === 'business') {
            return $this->createBusinessProfile($data);
        }

        $this->role = 'Customer';

        return $this->createCustomerProfile($data);
    }

    /**
     * Create a business profile for the user.
     *
     * @param array $data
     *
     * @return void
     */
    protected function createBusinessProfile(array $data)
    {
        return [
            'business' => $data['business'],
            'description' => 'We\'ll get it done.',
        ];
    }

    /**
     * Create user as customer profile.
     *
     * @param array $data
     *
     * @return array
     */
    protected function createCustomerProfile(array $data): array
    {
        return [
            'stripe_id' => $this->getClient()->createCustomer(
                array_merge(array_filter($data, function (string $key) {
                    return in_array($key, [
                        'name', 'description', 'email', 'phone',
                    ]);
                }, \ARRAY_FILTER_USE_KEY), $this->createAddress($data))
            )->id,
        ];
    }

    /**
     * Create address for user.
     *
     * @param array $data
     *
     * @return array
     */
    protected function createAddress(array $data): array
    {
        return [
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
        ];
    }

    /**
     * Get default user settings array.
     *
     * @return array
     */
    protected function setDefaultSettings(): array
    {
        return config('defaults.users.settings');
    }

    /**
     * Get instance of Stripe client.
     *
     * @return \App\Billing\Clients\Client
     */
    protected function getClient(): Client
    {
        return app(Client::class);
    }

    /**
     * Generate unique username from first name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function makeUsername(string $name): string
    {
        $name = trim($name);

        if (User::where('username', 'like', '%' . $name . '%')->count() !== 0) {
            return Str::studly("{$name}-" . Str::random('5'));
        }

        return Str::studly($name);
    }
}
