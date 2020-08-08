<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use App\Models\Ability;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Pipeline\Pipeline;
use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
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
            ->assignRolesAndAbilities()
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

    /**
     * Calculate charges using given resource.
     *
     * @param \App\Contracts\Models\Priceable $resource
     *
     * @return void
     */
    protected function calculateCharges(Priceable $resource)
    {
        $this->getCalculator($resource)->calculate();
    }

    /**
     * Get charge calculator instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return \App\Contracts\Support\Calculator
     */
    public function getCalculator(Model $resource): Calculator
    {
        return new Calculator($this->getPipeline(), $resource);
    }

    /**
     * Get Laravel pipeline instance.
     *
     * @return \Illuminate\Contracts\Pipeline\Pipeline
     */
    public function getPipeline(): Pipeline
    {
        return app()->make(Pipeline::class);
    }
}
