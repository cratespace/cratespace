<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Order;
use App\Mail\OrderPlaced;

class OrderPlacedEmailTest extends TestCase
{
    /** @test */
    public function it_contains_a_link_to_the_order_confirmation_page()
    {
        $order = make(Order::class, [
            'confirmation_number' => 'ORDERCONFIRMATION1234',
        ]);
        $email = new OrderPlaced($order);
        $rendered = $email->render();

        $this->assertStringContainsString(url('/orders/ORDERCONFIRMATION1234'), $rendered);
    }

    /** @test */
    public function email_has_a_subject()
    {
        $order = make(Order::class);
        $email = new OrderPlaced($order);

        $this->assertEquals('Your Cratespace Order', $email->build()->subject);
    }
}
