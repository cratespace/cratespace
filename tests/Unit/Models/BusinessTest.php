<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    public function testBusinessAlwaysAccompaniesUser()
    {
        $business = create(Business::class);

        $this->assertInstanceOf(User::class, $business->user);
    }

    public function testBusinessCanAddCredit()
    {
        $business = create(Business::class);

        $this->assertEquals(0, $business->credit);

        $business->addCredit(100);

        $this->assertEquals(100, $business->fresh()->credit);
    }

    public function testAmountShoudBePositiveWhenAddingCredit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Credit amount should be positive when ~adding~ to account');

        $business = create(Business::class);

        $business->addCredit(-100);
    }

    public function testAmountShoudBeNegativeWhenDeductingFromCredit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Credit amount should be negative when ~deducting~ to account');

        $business = create(Business::class);

        $business->deductCredit(100);
    }
}
