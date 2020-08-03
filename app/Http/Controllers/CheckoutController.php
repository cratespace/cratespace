<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Support\Formatter;
use App\Contracts\Billing\PaymentGateway;
use App\Billing\Charges\Calculator as ChargesCalculator;

class CheckoutController extends Controller
{
    /**
     * Instance of payment gateway.
     *
     * @var \App\Billing\FakePaymentGateway
     */
    protected $paymentGateway;

    /**
     * Create new controller instance.
     *
     * @param \App\Contracts\Billing\PaymentGateway $paymentGateway
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Show checkout page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Space $space)
    {
        return view('public.checkout.page', [
            'space' => $space,
            'charges' => $this->calculateCharges($space),
        ]);
    }

    /**
     * Calculate charges of customer purchase.
     *
     * @param \App\Models\Space $space
     *
     * @return array
     */
    protected function calculateCharges(Space $space): array
    {
        $charges = [];

        foreach ((new ChargesCalculator($space))->calculateCharges() as $name => $amount) {
            $charges[$name] = Formatter::moneyFormat((int) $amount);
        }

        return $charges;
    }
}
