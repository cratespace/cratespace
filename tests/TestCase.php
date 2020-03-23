<?php

namespace Tests;

use App\Models\User;
use App\Models\Business;
use Illuminate\View\View;
use App\Providers\ViewServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, RefreshDatabase, WithFaker;

    /**
     * Mock authenticated user.
     *
     * @param \App\Models\User $user
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
