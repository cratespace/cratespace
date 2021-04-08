<?php

namespace Tests\Unit\Models;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Contracts\Billing\Order;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceManageProductTest extends TestCase
{
    use RefreshDatabase;

    public function testGetMerchant()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->merchant());
        $this->assertTrue($space->owner->is($space->merchant()));
    }

    public function testAvailability()
    {
        Event::fake();

        $space = create(Space::class, ['departs_at' => now()->subDay()]);
        $space->reserve();

        $this->assertFalse($space->available());
    }

    public function testDetermineExpirationDate()
    {
        Event::fake();

        $space = create(Space::class, ['departs_at' => now()->tomorrow()]);

        $this->assertTrue($space->nearingExpiration());
    }

    public function testGetOrderDetails()
    {
        $space = create(Space::class);
        $space->order = m::mock(Order::class);

        $this->assertInstanceOf(Order::class, $space->getOrderDetails());
    }

    public function testProductDetails()
    {
        $space = create(Space::class);

        $this->assertEquals(array_merge($space->toArray(), [
            'key' => $space->getTable(),
        ]), $space->details());
    }

    public function testGetProductCode()
    {
        $space = create(Space::class);

        $this->assertEquals($space->code, $space->code());
    }

    public function testReserveAndRelease()
    {
        Event::fake();

        $space = create(Space::class);

        $space->reserve();
        $this->assertNotNull($space->fresh()->reserved_at);

        $space->release();
        $this->assertNull($space->fresh()->reserved_at);
    }

    public function testDetermineReservedStatus()
    {
        $space = create(Space::class, [
            'reserved_at' => now(),
        ]);

        $this->assertTrue($space->reserved());
    }
}
