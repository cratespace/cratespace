<?php

namespace Tests\Unit\Maintainers;

use Tests\TestCase;
use App\Models\Space;
use App\Maintainers\SpaceMaintainer;

class SpaceMaintainerTest extends TestCase
{
    /** @test */
    public function it_updates_the_status_of_all_spaces()
    {
        $availableSpace = create(Space::class);
        $expiredSpace = create(Space::class, ['departs_at' => now()->subMonth()]);

        $this->assertTrue($availableSpace->status === 'Available');
        $this->assertTrue($expiredSpace->status === 'Available');

        $spaceMaintainer = new SpaceMaintainer();
        $spaceMaintainer->runMaintenance();

        $this->assertTrue($availableSpace->refresh()->status === 'Available');
        $this->assertFalse($expiredSpace->refresh()->status === 'Available');
        $this->assertTrue($expiredSpace->refresh()->status === 'Expired');
    }
}
