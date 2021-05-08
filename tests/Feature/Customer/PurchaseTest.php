<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use Tests\Fixtures\ProductStub;
use App\Contracts\Products\Product;
use App\Contracts\Products\Inventory;
use App\Billing\Token\GeneratePaymentToken;
use App\Providers\InventoryServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PurchaseTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /**
     * The product stub instance.
     *
     * @var \App\Contracts\Products\Product
     */
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('billing.defaults.service', 'fake');

        InventoryServiceProvider::addToProductLine(ProductStub::class);

        $this->app->make(Inventory::class)->store(
            $this->product = new ProductStub('Test Product', 1500)
        );
    }

    public function testCustomerCanPurchaseItem()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class, [], 'asCustomer');
        $this->signIn($user);

        $response = $this->post('/orders', $this->validParameters([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'payment_token' => $this->generatePaymentToken($this->product),
            'product' => $this->product->getCode(),
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
