<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Support\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Actions\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return \App\Model\User
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $user = $this->createUser($data);

            $user->tap(function (User $user) use ($data): void {
                $this->isForBusiness($data)
                    ? $user->createAsBusiness($data)->assignRole('Business')
                    : $user->createAsCustomer($data)->assignRole('Customer');
            });

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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => Util::makeUsername($data['name']),
            'password' => Hash::make($data['password']),
            'settings' => $this->setDefaultSettings(),
            'locked' => $this->isForBusiness($data) ? true : false,
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
