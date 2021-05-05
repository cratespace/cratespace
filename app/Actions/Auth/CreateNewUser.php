<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cratespace\Sentinel\Support\Util;
use App\Actions\Business\CreateNewBusiness;
use App\Actions\Business\CreateNewCustomer;
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
            'locked' => false,
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
        return app(
            $this->parseUserType($data) === 'business'
                ? CreateNewBusiness::class
                : CreateNewCustomer::class
        )->create(array_merge($data, ['user' => $user]));
    }

    /**
     * Determine the type of user to be created.
     *
     * @param array $data
     *
     * @return string
     */
    public function parseUserType(array $data): string
    {
        if (isset($data['type']) && $data['type'] === 'business') {
            return 'business';
        }

        return 'customer';
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
