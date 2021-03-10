<?php

namespace App\Models;

use App\Models\Traits\Hashable;
use App\Models\Casts\ScheduleCast;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Actions\Orders\PlacesOrders;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cratespace\Preflight\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model
{
    use HasFactory;
    use Presentable;
    use Hashable;

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
     * Mark space as booked and create order details.
     *
     * @param array $details
     *
     * @return \App\Models\Order
     */
    public function placeOrder(array $details): Order
    {
        $this->update(['reserved_at' => now()]);

        return app(PlacesOrders::class)->make($details, $this);
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
     * Get full path to single resource page.
     *
     * @return string
     */
    public function getPathAttribute(): string
    {
        return route('spaces.show', $this);
    }

    /**
     * Get full price or product inclusive of all additional charges.
     *
     * @return int
     */
    public function fullPrice(): int
    {
        if (is_null($this->tax)) {
            return $this->price;
        }

        return $this->price + $this->tax;
    }
}
