<?php

namespace Tests\Unit\Values;

use Carbon\Carbon;
use App\Models\Values\Schedule;
use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase
{
    public function testInstantiation()
    {
        $schedule = new Schedule(
            $departs = Carbon::parse(now()->addDay())->format('M j, Y g:ia'),
            $arrives = Carbon::parse(now()->addDays(2))->format('M j, Y g:ia'),
        );

        $this->assertInstanceOf(Schedule::class, $schedule);
        $this->assertEquals($departs, $schedule->departsAt);
        $this->assertEquals($arrives, $schedule->arrivesAt);
    }

    public function testDetermineNearingDepartureDate()
    {
        $schedule = new Schedule(
            $departs = Carbon::parse(now()->tomorrow())->format('M j, Y g:ia'),
            $arrives = Carbon::parse(now()->addDays(2))->format('M j, Y g:ia'),
        );

        $this->assertTrue($schedule->nearingDeparture());
    }
}
