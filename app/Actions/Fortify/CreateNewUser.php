<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser extends AuthActions implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     *
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $input = $this->validate('register', $input);

        return DB::transaction(function () use ($input) {
            return tap($this->createUser($input), function (User $user) use ($input) {
                // $this->createBusiness($user, $input);

                // $this->createCreditAccount($user);
            });
        });
    }

    /**
     * Create new user profile.
     *
     * @param array $input
     *
     * @return \App\Models\User
     */
    protected function createUser(array $input): User
    {
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'username' => $this->makeUsername($input['name']),
            'password' => Hash::make($input['password']),
        ]);
    }

    /**
     * Create a business profile for the user.
     *
     * @param \App\Models\User $user
     * @param array            $input
     *
     * @return void
     */
    protected function createBusiness(User $user, array $input): void
    {
        $user->business()->create(['name' => $input['business']]);
    }

    /**
     * Create finance profile for the user.
     *
     * @param \App\Models\User
     *
     * @return void
     */
    protected function createCreditAccount(User $user): void
    {
        $user->account()->create(['user_id' => $user->id]);
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
        if (Str::contains($name, '.')) {
            [$title, $fullName] = explode('.', $name);

            $name = $fullName;
        }

        [$firstName, $lastName] = explode(' ', $name);

        $count = User::where('username', 'like', '%' . $firstName . '%')->count();

        if ($count !== 0) {
            return Str::studly($firstName . $lastName);
        }

        return $firstName;
    }
}
