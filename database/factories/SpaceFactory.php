<?php

namespace Database\Factories;

use App\Models\User;
use App\Products\Products\Space;
use Tests\Concerns\HasValidParameters;

class SpaceFactory
{
    use HasValidParameters;

    /**
     * Create new dummy space.
     *
     * @param array $data
     *
     * @return \App\Products\Products\Space
     */
    public static function createSpace(array $data = []): Space
    {
        $user = User::factory()->asBusiness()->create();

        return Space::create(array_merge(
            static::validParametersForSpace([
                'user_id' => $user->id,
                'base' => $user->base(),
            ]), $data)
        );
    }
}
