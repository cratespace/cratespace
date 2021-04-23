<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Order;
use App\Mail\NewOrderPlaced;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewOrderPlacedTest extends TestCase
{
    use RefreshDatabase;

    public function testEmailContainsLinkToViewOrderConfirmationPage()
    {
        $order = create(Order::class);

        $email = new NewOrderPlaced($order);
        $rendered = $email->render($email);

        $this->assertStringContainsString(route('orders.show', $order), $rendered);
    }

    public function testExpectedSubjectIsPresent()
    {
        $order = create(Order::class);

        $email = new NewOrderPlaced($order);

        $this->assertEquals('Cratespace - New Order Placed', $email->build()->subject);
    }
}
