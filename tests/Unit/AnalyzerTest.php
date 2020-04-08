<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Analytics\SpacesAnalyzer;
use App\Analytics\OrdersAnalyzer;

class AnalyzerTest extends TestCase
{
    /** @test */
    public function it_can_analize_spaces_according_to_status()
    {
        $user = $this->signIn();

        create(Space::class, ['user_id' => $user->id], 2);
        create(Space::class, [
            'user_id' => $user->id,
            'status' => 'Ordered'
        ], 3);

        $analyzer = new SpacesAnalyzer(Space::whereUserId($user->id)->get());
        $results = $analyzer->analyze();

        $this->assertEquals(2, $results['available']);
        $this->assertEquals(3, $results['ordered']);
    }

    /** @test */
    public function it_can_analize_orderd_according_to_status()
    {
        $user = $this->signIn();

        create(Order::class, ['user_id' => $user->id], 2);
        create(Order::class, [
            'user_id' => $user->id,
            'status' => 'Confirmed'
        ], 3);

        $analyzer = new OrdersAnalyzer(Order::whereUserId($user->id)->get());
        $results = $analyzer->analyze();

        $this->assertEquals(2, $results['pending']);
        $this->assertEquals(3, $results['confirmed']);
    }
}
