<?php

namespace Tests\Support;

use App\Models\Role;
use App\Models\User;
use App\Models\Ability;
use App\Models\Account;
use App\Models\Business;

trait CreatesFakeUser
{
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
            ->assignRolesAndAbilities()
            ->actingAs($this->user);

        return $this->user;
    }

    /**
     * Create a fake business profile for the user.
     *
     * @return \Tests\TestCase
     */
    protected function createBusiness()
    {
        create(Business::class, ['user_id' => $this->user->id]);

        return $this;
    }

    /**
     * Create a fake financial account for the user.
     *
     * @return \Tests\TestCase
     */
    protected function createFinancialAccount()
    {
        create(Account::class, ['user_id' => $this->user->id]);

        return $this;
    }

    /**
     * Create and assign customer role.
     *
     * @return \Tests\TestCase
     */
    protected function assignRolesAndAbilities()
    {
        $customerRole = Role::firstOrCreate([
            'title' => 'customer',
            'label' => 'Customer',
        ]);

        $purchaseSpace = Ability::firstOrCreate([
            'title' => 'purchase_spaces',
            'label' => 'Purchase spaces',
        ]);

        $customerRole->allowTo($purchaseSpace);

        $this->user->assignRole($customerRole);

        return $this;
    }
}
