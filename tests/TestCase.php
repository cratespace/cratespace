<?php

namespace Tests;

use App\Models\User;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    /**
     * Instance of fake user.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Mock authenticated user.
     *
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    protected function signIn($user = null): User
    {
        $this->user = $user ?: create(User::class);

        $this->createBusiness()
            ->createFinancialAccount()
            ->actingAs($this->user);

        return $this->user;
    }

    /**
     * Create a fake business profile for the user.
     *
     * @return \Tests\TestCase
     */
    protected function createBusiness(): TestCase
    {
        create(Business::class, ['user_id' => $this->user->id]);

        return $this;
    }

    /**
     * Create a fake financial account for the user.
     *
     * @return \Tests\TestCase
     */
    protected function createFinancialAccount(): TestCase
    {
        create(Account::class, ['user_id' => $this->user->id]);

        return $this;
    }
}
