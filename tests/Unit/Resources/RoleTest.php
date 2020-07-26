<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Ability;
use Illuminate\Support\Collection;

class RoleTest extends TestCase
{
    /** @test */
    public function it_belongs_to_many_abilities()
    {
        $role = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $this->assertInstanceOf(Collection::class, $role->abilities);
    }

    /** @test */
    public function it_can_allow_itself_abilities()
    {
        $role = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $ability = Ability::create([
            'title' => 'dummy_ability',
            'label' => 'Dummy ability',
        ]);

        $role->allowTo($ability);

        $this->assertTrue($role->abilities->contains($ability));
    }
}
