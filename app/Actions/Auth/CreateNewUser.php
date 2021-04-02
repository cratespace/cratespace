<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Support\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableUser;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data): AuthenticatableUser
    {
        return DB::transaction(function () use ($data): User {
            return tap($this->createUser($data), function (User $user) use ($data): void {
                ($business = $this->isForBusiness($data))
                    ? $user->createAsBusiness($data)
                    : $user->createAsCustomer($data);

                $user->assignRole($business ? 'Business' : 'Customer');
            });
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => Util::makeUsername($data['name']),
            'password' => Hash::make($data['password']),
            'settings' => $this->setDefaultSettings(),
            'locked' => $data['type'] === 'customer' ? false : true,
        ]);
    }

    /**
     * Determine if the user is a business user or a customer.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function isForBusiness(array $data): bool
    {
        return isset($data['type']) && $data['type'] === 'business';
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
}
