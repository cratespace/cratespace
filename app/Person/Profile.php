<?php

namespace App\Person;

use App\Models\User;
use Illuminate\Support\Str;
use App\Contracts\Responsibility;
use Illuminate\Support\Facades\Hash;

class Profile implements Responsibility
{
    /**
     * Perform create responsibility.
     *
     * @param  \App\Models\User   $user
     * @param  array  $data
     * @return App\Models\User
     */
    public function create(User $person, array $data)
    {
        return $person->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $this->makeUsername($data['name']),
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Generate unique username from first name.
     *
     * @param  string $name
     * @return string
     */
    protected function makeUsername($name)
    {
        [$firstName, $lastName] = explode(' ', $name);

        $count = User::where('username', 'like', '%'.$firstName.'%')->count();

        if ($count < 0) {
            return Str::kebab($firstName . $lastName);
        }

        return $firstName;
    }
}
