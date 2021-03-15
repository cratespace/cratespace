<?php

namespace App\Models;

use App\Models\Traits\Hashable;
use App\Models\Traits\Directable;
use App\Models\Traits\Marketable;
use App\Models\Casts\ScheduleCast;
use App\Contracts\Purchases\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\DeterminesStatus;
use App\Models\Concerns\InteractsWithOrder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cratespace\Preflight\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model implements Product
{
    use HasFactory;
    use Presentable;
    use Hashable;
    use Marketable;
    use InteractsWithOrder;
    use DeterminesStatus;
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
     * Reserve space for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->update(['reserved_at' => now()]);
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->update(['reserved_at' => null]);
    }

    /**
     * Get unique ID of product.
     *
     * @return string
     */
    public function id(): string
    {
        return $this->code;
    }
}
