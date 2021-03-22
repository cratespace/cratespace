<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Support\Util;
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
        return tap($this->createUser($data), function (User $user) use ($data) {
            if (isset($data['type']) && $data['type'] === 'business') {
                $user->createAsBusiness($data);

                $user->assignRole('Business');

                return $user;
            }

            $user->createAsCustomer($data);

            $user->assignRole('Customer');

            return $user;
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
        ]);
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
