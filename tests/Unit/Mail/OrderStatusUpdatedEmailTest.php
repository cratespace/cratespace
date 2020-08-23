<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Order;
use App\Mail\OrderStatusUpdatedMail;

class OrderStatusUpdatedEmailTest extends TestCase
{
    /** @test */
    public function it_contains_a_link_to_the_order_status_page()
    {
        $order = make(Order::class, [
            'confirmation_number' => 'ORDERCONFIRMATION1234',
        ]);
        $email = new OrderStatusUpdatedMail($order);
        $rendered = $email->render();

        $this->assertStringContainsString(url('/orders/ORDERCONFIRMATION1234'), $rendered);
    }

    /** @test */
    public function it_has_a_subject()
    {
        $order = make(Order::class);
        $email = new OrderStatusUpdatedMail($order);

        $this->assertEquals('Cratespace Order Status Updated', $email->build()->subject);
    }
}
