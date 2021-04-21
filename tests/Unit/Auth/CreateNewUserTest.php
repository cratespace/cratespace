<?php

namespace Tests\Unit\Auth;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Actions\Auth\CreateNewUser;

class CreateNewUserTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testCanCreateNewCustomer()
    {
        $customer = m::mock(User::class);
        $customer->shouldReceive('isCustomer')
            ->andReturn(true);

        $data = $this->data();

        $creator = m::mock(CreateNewUser::class);
        $creator->shouldAllowMockingProtectedMethods();

        $creator->shouldReceive('isForBusiness')
            ->with($data)
            ->andReturn('false');
        $creator->shouldReceive('create')
            ->with($data)
            ->andReturn($customer);

        $this->assertEquals($customer, ($creator->create($data)));
        $this->assertTrue($customer->isCustomer());
    }

    public function testCanCreateNewBusiness()
    {
        $business = m::mock(User::class);
        $business->shouldReceive('isBusiness')
            ->andReturn(true);

        $data = $this->data([
            'type' => 'business',
        ]);

        $creator = m::mock(CreateNewUser::class);
        $creator->shouldAllowMockingProtectedMethods();

        $creator->shouldReceive('isForBusiness')
            ->with($data)
            ->andReturn('true');
        $creator->shouldReceive('create')
            ->with($data)
            ->andReturn($business);

        $this->assertEquals($business, ($creator->create($data)));
        $this->assertTrue($business->isBusiness());
    }

    /**
     * Test data provider.
     *
     * @param array $overrides
     *
     * @return array
     */
    protected function data(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Father Jack Hackett',
            'email' => 'fr.j.hackett@craggyisle.com',
            'phone' => '0712345678',
            'password' => 'dontTellMeImStillInThatFekingIsland',
            'password_confirmation' => 'dontTellMeImStillInThatFekingIsland',
            'type' => 'customer',
        ], $overrides);
    }
}
