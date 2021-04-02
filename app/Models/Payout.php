<?php

namespace App\Models;

use App\Support\Money;
use App\Contracts\Billing\Order;
use App\Models\Casts\PaymentCast;
use App\Contracts\Billing\Product;
use Illuminate\Database\Eloquent\Model;
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
     * Determine if the payment was successfully completed.
     *
     * @return bool
     */
    public function paid(): bool
    {
        return ! is_null($this->paid_at);
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
     * Get the product the payout was made for.
     *
     * @return \App\Contracts\Billing\Product
     */
    public function product(): Product
    {
        return $this->payment_intent->product();
    }

    /**
     * Get the order details the payout was made for.
     *
     * @return \App\Contracts\Billing\Order
     */
    public function order(): Order
    {
        return $this->product()->order;
    }
}
