<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Products\Line\Space;
use App\Services\Stripe\Customer;
use App\Contracts\Products\Product;
use App\Models\Space as ModelsSpace;
use App\Billing\Token\GeneratePaymentToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripePurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function testCustomerCanPurchaseItem()
    {
        $this->withoutEvents();
        $this->withoutExceptionHandling();

        $user = create(User::class, [], 'asCustomer');
        $stripeService = Customer::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
        $user->customer->update(['service_id' => $stripeService->id]);
        $product = Space::find(create(ModelsSpace::class)->id);
        $this->signIn($user);

        $response = $this->post('/orders', $this->validParameters([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'payment_token' => $this->generatePaymentToken($product),
            'product' => $product->getCode(),
            'customer' => $user->customerId(),
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
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
