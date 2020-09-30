<?php

namespace App\Auth\Actions;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Auth\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return tap($this->createUser($data), function (User $user) use ($data) {
                $this->createBusiness($user, $data);

                $this->createFinancialAccount($user);

                // $this->assignRolesAndAbilities($user);
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
            'phone' => $data['phone'],
            'username' => $this->makeUsername($data['name']),
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a business profile for the user.
     *
     * @param array $data
     *
     * @return void
     */
    protected function createBusiness(User $user, array $data): void
    {
        $user->business()->create(['name' => $data['business']]);
    }

    /**
     * Create finance profile for the user.
     *
     * @param array $data
     *
     * @return void
     */
    protected function createFinancialAccount(User $user): void
    {
        $user->account()->create(['user_id' => $user->id]);
    }

    /**
     * Create and assign customer role.
     *
     * @return void
     */
    protected function assignRolesAndAbilities($user): void
    {
        $developer = Role::createAndAssign('developer', 'Developer', [
            'create', 'read', 'update',
        ]);

        $user->assignRole($developer);
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
