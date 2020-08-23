<?php

namespace Tests\Unit\Presenters;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Models\Business;
use App\Support\Formatter;

class SpacePresenterTest extends TestCase
{
    /** @test */
    public function it_can_display_price_information_in_money_format()
    {
        $space = create(Space::class, ['price' => 12.3]);
        $price = Formatter::money($space->price);

        $this->assertEquals($price, $space->present()->price);
        $this->assertTrue(is_string($space->present()->price));
    }

    /** @test */
    public function it_can_display_full_price_information_in_money_format()
    {
        $space = create(Space::class, ['price' => 12.3, 'tax' => 0.7]);
        $fullPrice = Formatter::money($space->price + $space->tax);

        $this->assertEquals($fullPrice, $space->present()->fullPrice);
        $this->assertTrue(is_string($space->present()->fullPrice));
    }

    /** @test */
    public function it_can_display_volume_information()
    {
        $space = create(Space::class);
        $volume = $space->height * $space->width * $space->length;

        $this->assertEquals($volume, $space->present()->volume);
        $this->assertTrue(is_int($space->present()->volume));
    }

    /** @test */
    public function it_can_give_an_array_of_status_information()
    {
        $availableSpace = create(Space::class);
        $this->assertEquals(
            ['text' => 'Available', 'color' => 'green'],
            $availableSpace->present()->status
        );

        $orderedSpace = create(Space::class, ['reserved_at' => Carbon::now()->subDays(1)]);
        $this->assertEquals(
            ['text' => 'Ordered', 'color' => 'blue'],
            $orderedSpace->present()->status
        );

        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subDays(1)]);
        $this->assertEquals(
            ['text' => 'Expired', 'color' => 'gray'],
            $expiredSpace->present()->status
        );

        $expiredOrderedSpace = create(Space::class, [
            'reserved_at' => Carbon::now()->subDays(2),
            'departs_at' => Carbon::now()->subDays(1),
        ]);
        $this->assertEquals(
            ['text' => 'Ordered', 'color' => 'blue'],
            $expiredOrderedSpace->present()->status
        );
    }

    /** @test */
    public function it_can_display_business_name()
    {
        $user = $this->signIn();
        $space = create(Space::class, ['user_id' => $user->id]);
        $businessName = Business::where('user_id', $space->user_id)->first()->name;

        $this->assertEquals($businessName, $space->present()->businessName);
    }
}
