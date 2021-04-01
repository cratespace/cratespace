<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Events\PaymentFailed;
use App\Events\PaymentSuccessful;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Event;
use App\Actions\Customer\GeneratePaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PurchaseTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testPurchaseProduct()
    {
        Event::fake([
            PaymentFailed::class,
            PaymentSuccessful::class,
        ]);

        $this->withoutExceptionHandling();

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $token = $this->generatePyamentToken($product);

        $response = $this->post(
            '/orders/' . $product->code(),
            $this->validParameters([
                'payment_token' => $token,
            ])
        );

        $response->assertStatus(303);
        $this->assertFalse($product->available());
    }

    /**
     * Generate a pyament token to proceed with purchase.
     *
     * @param \App\Contracts\Billing\Product $product
     *
     * @return string
     */
    protected function generatePyamentToken(Product $product): string
    {
        return $this->app->make(GeneratePaymentToken::class)->generate($product);
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'James Silverman',
            'email' => 'james.silver@monster.com',
            'phone' => '0723573567',
            'business' => 'Cthulus',
            'payment_method' => 'pm_card_visa',
        ], $overrides);
    }
}
