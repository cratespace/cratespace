<?php

namespace App\Models;

use Stripe\Order;
use Carbon\Carbon;
use App\Support\Money;
use App\Models\Casts\PaymentCast;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidActionException;
use App\Contracts\Billing\Payment as PaymentContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payout extends Model implements PaymentContract
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment' => PaymentCast::class,
        'paid_at' => 'datetime',
    ];

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format($this->amount);
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return (int) $this->amount;
    }

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentActionRequired
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void
    {
    }

    /**
     * Determine if the payment was successful.
     *
     * @return bool
     */
    public function isSucceeded(): bool
    {
        return ! is_null($this->paid_at);
    }

    /**
     * Determine if the payment was cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return ! $this->isSucceeded();
    }

    /**
     * Mark payout as payed.
     *
     * @return void
     */
    public function pay(): void
    {
        $this->forceFill(['paid_at' => Carbon::now()])->saveQuietly();
    }

    /**
     * Cancel payment.
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidActionException
     */
    public function cancel(): void
    {
        if ($this->paid()) {
            throw new InvalidActionException('Payout has already been paid for');
        }

        $this->delete();
    }

    /**
     * Get the business the payout is meant for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order details the payout was made for.
     *
     * @return \App\Contracts\Orders\Order
     */
    public function order(): Order
    {
        return $this->product()->order;
    }

    /**
     * Find a payout with the given payment ID.
     *
     * @param string $payment
     *
     * @return \App\Models\Payout|null
     */
    public static function findUsingPayment(string $payment): ?Payout
    {
        return static::wherePayment($payment)->first();
    }
}
