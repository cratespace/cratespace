<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToOwner()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->owner);
    }

    public function testHasUniqueCode()
    {
        $spaces = create(Space::class, [], null, 10);
        $space = $spaces->first();

        $codes = $spaces->pluck('code')
            ->filter(function ($code) use ($space) {
                return $code === $space->code;
            });

        $this->assertEquals(1, $codes->count());
    }

    public function testHasDimensions()
    {
        $space = create(Space::class);

        $this->assertNotNull($space->dimensions->height);
        $this->assertIsInt($space->dimensions->height);
        $this->assertNotNull($space->dimensions->width);
        $this->assertIsInt($space->dimensions->width);
        $this->assertNotNull($space->dimensions->length);
        $this->assertIsInt($space->dimensions->length);
    }

    public function testHasMaximumAllowableWeight()
    {
        $space = create(Space::class);

        $this->assertNotNull($space->weight);
        $this->assertIsInt($space->weight);
    }

    public function testNoteCanBeAttached()
    {
        $space = create(Space::class);

        $this->assertNull($space->note);

        $space->attachNote($note = 'This space is for internal use only');

        $this->assertEquals($note, $space->fresh()->note);
    }

    public function testHasPriceAndOptionalTax()
    {
        $space = create(Space::class);

        $this->assertNotNull($space->price);
        $this->assertIsInt($space->price);
        $this->assertNotNull($space->tax);
        $this->assertIsInt($space->tax);
    }

    public function testBelongsToAType()
    {
        $space = create(Space::class);

        $this->assertNotNull($space->type);
    }

    public function testAlwaysBasedAtUserBase()
    {
        $user = create(User::class, [
            'address' => ['country' => 'United Kingdom'],
        ], 'asBusiness');
        $space = create(Space::class, ['user_id' => $user->id]);

        $this->assertEquals('United Kingdom', $space->base);
    }
}
