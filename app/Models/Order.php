<?php

namespace App\Models;

use App\Support\Money;
use App\Events\OrderCanceled;
use App\Models\Casts\PaymentCast;
use App\Models\Traits\Directable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Purchases\Order as OrderContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements OrderContract
{
    use HasFactory;
    use Directable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confirmation_number',
        'name',
        'email',
        'phone',
        'business',
        'price',
        'tax',
        'total',
        'note',
        'space_id',
        'user_id',
        'customer_id',
        'details',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => PaymentCast::class,
    ];

    /**
     * Get the space the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    /**
     * Get the business the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the customer the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format($this->total);
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return (int) $this->total;
    }

    /**
     * Get the details attribute as an object.
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function details(?string $key = null)
    {
        $details = (object) $this->details;

        if (is_null($key)) {
            return $details;
        }

        return $details->{$key};
    }

    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string
    {
        return 'TODO';
    }

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->space->release();

        OrderCanceled::dispatch($this);

        $this->delete();
    }
}
