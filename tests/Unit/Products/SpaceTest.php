<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Database\Factories\SpaceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testSpaceHasUniqueCode()
    {
        $space = SpaceFactory::createSpace();

        $this->assertIsString($space->code());
    }

    public function testSpaceCanSetUniqueCode()
    {
        $space = SpaceFactory::createSpace();

        $space->setCode($code = Str::random(40));

        $this->assertSame($code, $space->code());
    }

    public function testSpaceHasIDAsName()
    {
        $space = SpaceFactory::createSpace();

        $this->assertEquals($space->id, $space->name());
    }

    public function testSpaceHasMerchantDetails()
    {
        $space = SpaceFactory::createSpace();

        $this->assertInstanceOf(User::class, $space->merchant());
    }

    public function testSpaceCanBeReserved()
    {
        $space = SpaceFactory::createSpace();

        $space->reserve();

        $this->assertNotNull($space->reserved_at);
        $this->assertTrue($space->reserved());
    }

    public function testSpaceCanBeReleasedFromReservation()
    {
        $space = SpaceFactory::createSpace();

        $space->reserve();

        $this->assertTrue($space->reserved());

        $space->release();

        $this->assertFalse($space->reserved());
    }

    public function testSpaceCanGetFullAmount()
    {
        $space = SpaceFactory::createSpace([
            'price' => 1000,
            'tax' => 500,
        ]);

        $this->assertEquals(1500, $space->fullAmount());
    }

    public function testSpaceCanDetermineAvailability()
    {
        $availableSpace = SpaceFactory::createSpace();
        $reservedSpace = SpaceFactory::createSpace();

        $reservedSpace->reserve();

        $this->assertTrue($availableSpace->available());
        $this->assertFalse($reservedSpace->available());
    }

    public function testSpaceCanDetermineExpiration()
    {
        $space = SpaceFactory::createSpace([
            'departs_at' => now(),
        ]);

        $this->assertTrue($space->expired());
    }

    public function testSpaceCanDetermineNearByExpirationTime()
    {
        $space = SpaceFactory::createSpace([
            'departs_at' => now()->tomorrow(),
        ]);

        $this->assertTrue($space->nearingExpiration());
    }

    public function testSpaceCanGetFullDetails()
    {
        $space = SpaceFactory::createSpace();

        $this->assertEquals(
            array_merge(['product_type' => $space->getTable()], $space->toArray()),
            $space->details()
        );
    }
}
