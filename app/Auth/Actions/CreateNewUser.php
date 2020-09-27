<?php

namespace App\Auth\Actions;

use App\Models\Role;
use App\Models\User;
use App\Models\Ability;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Auth\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Instance of new user being created.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        $this->user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $this->makeUsername($data['name']),
            'password' => Hash::make($data['password']),
        ]);

        $this->createBusiness($data)
            ->createFinancialAccount($data)
            ->assignRolesAndAbilities();

        return $this->user;
    }

    /**
     * Create a business profile for the user.
     *
     * @param array $data
     *
     * @return \App\Auth\Actions\CreateNewUser
     */
    protected function createBusiness(array $data): CreateNewUser
    {
        $this->user->business()->create(['name' => $data['business']]);

        return $this;
    }

    /**
     * Create finance profile for the user.
     *
     * @param array $data
     *
     * @return \App\Auth\Actions\CreateNewUser
     */
    protected function createFinancialAccount(array $data): CreateNewUser
    {
        $this->user->account()->create(['user_id' => $this->user->id]);

        return $this;
    }

    /**
     * Create and assign customer role.
     *
     * @return \App\Auth\Actions\CreateNewUser
     */
    protected function assignRolesAndAbilities(): CreateNewUser
    {
        $businessRole = Role::firstOrCreate([
            'title' => 'business',
            'label' => 'Business',
        ]);

        $manageBusiness = Ability::firstOrCreate([
            'title' => 'manage data',
            'label' => 'Manage data',
        ]);

        $businessRole->allowTo($manageBusiness);

        $this->user->assignRole($businessRole);

        return $this;
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
        [$firstName, $lastName] = explode(' ', $name);

        $count = User::where('username', 'like', '%' . $firstName . '%')->count();

        if ($count !== 0) {
            return Str::studly($firstName . $lastName);
        }

        return $firstName;
    }
}
