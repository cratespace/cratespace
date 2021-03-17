<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
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

    public function testBusinessCanDeductCredit()
    {
        $business = create(Business::class);

        $this->assertEquals(0, $business->credit);

        $business->deductCredit(100);

        $this->assertEquals(-100, $business->fresh()->credit);
    }
}
