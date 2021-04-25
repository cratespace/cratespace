<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testSpaceHasUniqueCode()
    {
        $space = create(Space::class);

        $this->assertIsString($space->code());
    }

    public function testSpaceCanSetUniqueCode()
    {
        $space = create(Space::class);

        $space->setCode($code = Str::random(40));

        $this->assertSame($code, $space->code());
    }

    public function testSpaceHasIDAsName()
    {
        $space = create(Space::class);

        $this->assertEquals($space->id, $space->name());
    }

    public function testSpaceHasMerchantDetails()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->merchant());
    }

    public function testSpaceCanBeReserved()
    {
        $space = create(Space::class);

        $space->reserve();

        $this->assertNotNull($space->reserved_at);
        $this->assertTrue($space->reserved());
    }

    public function testSpaceCanBeReleasedFromReservation()
    {
        $space = create(Space::class);

        $space->reserve();

        $this->assertTrue($space->reserved());

        $space->release();

        $this->assertFalse($space->reserved());
    }

    public function testSpaceCanGetFullAmount()
    {
        $space = create(Space::class, [
            'price' => 1000,
            'tax' => 500,
        ]);

        $this->assertEquals(1500, $space->fullAmount());
    }

    public function testSpaceCanDetermineAvailability()
    {
        $availableSpace = create(Space::class);
        $reservedSpace = create(Space::class);

        $reservedSpace->reserve();

        $this->assertTrue($availableSpace->available());
        $this->assertFalse($reservedSpace->available());
    }

    public function testSpaceCanDetermineExpiration()
    {
        $space = create(Space::class, [
            'departs_at' => now(),
        ]);

        $this->assertTrue($space->expired());
    }

    public function testSpaceCanDetermineNearByExpirationTime()
    {
        $space = create(Space::class, [
            'departs_at' => now()->tomorrow(),
        ]);

        $this->assertTrue($space->nearingExpiration());
    }

    public function testSpaceCanGetFullDetails()
    {
        $space = create(Space::class);

        $this->assertEquals(
            array_merge(['product_type' => $space->getTable()], $space->toArray()),
            $space->details()
        );
    }
}
