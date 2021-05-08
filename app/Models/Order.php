<?php

namespace App\Models;

use App\Models\Casts\PaymentCast;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasEncryptableCode;
use Cratespace\Preflight\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Filterable;
    use HasEncryptableCode;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
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
        return 'code';
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
     * Find an order with the given confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return \App\Models\Order
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByConfirmationNumber(string $confirmationNumber): Order
    {
        return static::where(
            'confirmation_number',
            $confirmationNumber
        )->firstOrFail();
    }
}
