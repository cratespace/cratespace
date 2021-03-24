<?php

namespace App\Models;

use Carbon\Carbon;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Contracts\Billing\Order;
use App\Contracts\Billing\Payment;
use App\Contracts\Billing\Product;
use App\Models\Casts\ScheduleCast;
use Illuminate\Database\Eloquent\Model;
use Cratespace\Preflight\Models\Traits\Hashable;
use Cratespace\Preflight\Models\Traits\Directable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cratespace\Preflight\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model implements Product
{
    use HasFactory;
    use Presentable;
    use Hashable;
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
        'code',
        'departs_at',
        'arrives_at',
        'reserved_at',
        'origin',
        'destination',
        'height',
        'width',
        'length',
        'weight',
        'note',
        'price',
        'tax',
        'user_id',
        'type',
        'base',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reserved_at' => 'datetime',
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
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
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order details of the space.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'space_id');
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->update(['reserved_at' => now()]);

        ProductReserved::dispatch($this);
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->update(['reserved_at' => null]);

        ProductReleased::dispatch($this);
    }

    /**
     * Get full price of product in integer value.
     *
     * @return int
     */
    public function fullPrice(): int
    {
        return $this->price + $this->tax;
    }

    /**
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Billing\Order
     */
    public function placeOrder(Payment $payment): Order
    {
        $this->reserve();

        $order = $this->order()->create($payment->details());

        return $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        if ($this->departs_at->isBefore(Carbon::now())) {
            return ! is_null($this->reserved_at) || $this->order()->exists();
        }
    }
}
