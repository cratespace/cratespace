<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Ability;
use Illuminate\Support\Collection;

class AbilityTest extends TestCase
{
    /** @test */
    public function it_belongs_to_many_roles()
    {
        $ability = Ability::create([
            'title' => 'dummy_ability',
            'label' => 'Dummy ability',
        ]);

        $this->assertInstanceOf(Collection::class, $ability->roles);
    }
}
