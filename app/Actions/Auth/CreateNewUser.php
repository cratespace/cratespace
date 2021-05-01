<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cratespace\Sentinel\Support\Util;
use Cratespace\Sentinel\Support\Traits\Fillable;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use Fillable;

    /**
     * Create a newly registered user.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = $this->createUser(
                $this->filterFillable($data, User::class)
            );

            $this->createProfile($user, $data);

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
            'phone' => $data['phone'],
            'username' => Util::makeUsername($data['name']),
            'password' => Hash::make($data['password']),
            'settings' => $this->setDefaultSettings(),
            'address' => [],
            'locked' => $data['type'] === 'business' ? true : false,
        ]);
    }

    /**
     * Create a profile for the user.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return \App\Models\User
     */
    protected function createProfile(User $user, array $data): User
    {
        if ($data['type'] === 'business') {
            $user->createBusinessProfile($data);
            $user->assignRole('Business');

            return $user;
        }

        $user->createCustomerProfile($data);
        $user->assignRole('Customer');

        return $user;
    }

    /**
     * Get default user settings array.
     *
     * @return array
     */
    protected function setDefaultSettings(): array
    {
        return config('defaults.users.settings', []);
    }
}
