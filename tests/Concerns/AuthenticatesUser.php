<?php

namespace Tests\Concerns;

use Tests\TestCase;
use App\Models\User;

trait AuthenticatesUser
{
    /**
     * Create and set the currently logged in user for the application.
     *
     * @param mixed|null $user
     * @param array      $overrides
     *
     * @return \Tests\TestCase
     */
    public function signIn($user = null, array $overrides = []): TestCase
    {
        $user = $user ?: create(User::class, $overrides);

        return $this->actingAs($user);
    }
}
