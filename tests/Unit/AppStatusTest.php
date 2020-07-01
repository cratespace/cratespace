<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Providers\Traits\AppStatus;

class AppStatusTest extends TestCase
{
    use AppStatus;

    /** @test */
    public function it_can_determine_if_a_database_conneciton_is_available()
    {
        $this->assertFalse($this->hasDatabaseConnection());
    }
}
