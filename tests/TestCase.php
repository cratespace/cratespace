<?php

namespace Tests;

<<<<<<< HEAD
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
=======
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    /**
     * Mock authenticated user.
     *
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);

        $user->each(function ($user) {
            create(Business::class, ['user_id' => $user->id]);
        });

        $this->actingAs($user);

        return $user;
    }
}
