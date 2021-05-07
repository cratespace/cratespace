<?php

namespace Tests\Feature\Customer;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Products\Line\Space;
use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;
use App\Models\Space as SpaceModel;
use App\Billing\PaymentToken\GeneratePaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PurchaseTest extends TestCase implements Postable
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testCustomerCanPurchaseItem()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class, [], 'asCustomer');
        $product = Space::find(create(SpaceModel::class)->id);
        $details = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'payment_token' => $this->generatePaymentToken($product),
            'product' => $product->getCode(),
            'customer' => $user->customerId(),
        ];

        $this->signIn($user);

        $response = $this->post('/orders', $this->validParameters($details));

        $response->assertStatus(303);
    }

    /**
     * Generate a valid payment token.
     *
     * @param \App\Contracts\Products\Product $product
     *
     * @return string
     */
    protected function generatePaymentToken(Product $product): string
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
            'payment_method' => 'pm_card_visa',
        ], $overrides);
    }
}
