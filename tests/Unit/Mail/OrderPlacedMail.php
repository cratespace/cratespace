<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Order;
use App\Mail\OrderPlacedSuccessfully;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderPlacedMail extends TestCase
{
    use RefreshDatabase;

    public function testEmailContainsLinkToViewOrderConfirmationPage()
    {
        $order = create(Order::class);

        $email = new OrderPlacedSuccessfully($order);
        $rendered = $email->render($email);

        $this->assertStringContainsString(route('orders.show', $order), $rendered);
    }

    public function testExpectedSubjectIsPresent()
    {
        $order = create(Order::class);

        $email = new OrderPlacedSuccessfully($order);

        $this->assertEquals('Cratespace - Order Placed Successfully', $email->build()->subject);
    }
}
