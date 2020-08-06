<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Space;

class SpaceTest extends TestCase
{
    /** @test */
    public function it_has_a_set_of_required_attributes()
    {
        $space = create(Space::class);

        $this->assertDatabaseHas('spaces', [
            'uid' => $space->uid,
            'departs_at' => $space->departs_at,
            'arrives_at' => $space->arrives_at,
            'origin' => $space->origin,
            'destination' => $space->destination,
            'height' => $space->height,
            'width' => $space->width,
            'length' => $space->length,
            'weight' => $space->weight,
            'price' => $space->price,
            'tax' => $space->tax,
            'user_id' => $space->user_id,
            'type' => $space->type,
        ]);
    }
}
