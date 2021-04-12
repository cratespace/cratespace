<?php

namespace App\Models;

use App\Support\Money;
use App\Events\OrderCancelled;
use App\Models\Casts\PaymentCast;
use App\Contracts\Billing\Product;
use App\Facades\ConfirmationNumber;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Billing\Order as OrderContract;
use Cratespace\Preflight\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements OrderContract
{
    use HasFactory;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uid',
        'user_id',
        'customer_id',
        'confirmation_number',
        'orderable_id',
        'orderable_type',
        'amount',
        'payment',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payment' => PaymentCast::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    /**
     * Get the business the order was placed at.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the customer the order was placed for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the order belonging to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

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
        return $this->amount;
    }

    /**
     * Determine if the payment was successfully completed.
     *
     * @return bool
     */
    public function paid(): bool
    {
        return $this->payment->paid();
    }

    /**
     * Get the product associated with this order.
     *
     * @return \App\Contracts\Billing\Product
     */
    public function product(): Product
    {
        return $this->orderable;
    }

    /**
     * Determine if the order has been cofirmed.
     *
     * @return bool
     */
    public function confirmed(): bool
    {
        if (! is_null($this->confirmation_number)) {
            return ConfirmationNumber::validate($this->confirmation_number);
        }

        return false;
    }

    /**
     * Confirm order for customer.
     *
     * @return void
     */
    public function confirm(): void
    {
        if (! is_null($this->confirmation_number)) {
            return;
        }

        $this->forceFill([
            'confirmation_number' => ConfirmationNumber::generate(),
        ])->saveQuietly();
    }

    /**
     * Cancel this order.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->product()->release();

        OrderCancelled::dispatch($this);

        $this->delete();
    }

    /**
     * Determine if the order can be cancelled.
     *
     * @return bool
     */
    public function canCancel(): bool
    {
        return ! $this->product()->nearingExpiration();
    }

    /**
     * Find an order with the given confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return \App\Models\Order
     */
    public static function findByConfirmationNumber(string $confirmationNumber): Order
    {
        return static::where('confirmation_number', $confirmationNumber)->firstOrFail();
    }
}
