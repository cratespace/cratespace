<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Casts\ScheduleCast;
use App\Models\Traits\Presentable;
use App\Contracts\Models\Priceable;
use App\Models\Traits\Redirectable;
use App\Models\Concerns\DetectsStatus;
use Illuminate\Database\Eloquent\Model;

class Space extends Model implements Priceable
{
    use DetectsStatus,
        Filterable,
        Presentable,
        Redirectable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * Preferred route key name.
     *
     * @var string
     */
    protected static $routeKey = 'code';

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
     * Get all chargeable attributes.
     *
     * @return array
     */
    public function getCharges(): array
    {
        return [
            'price' => $this->price,
            'tax' => $this->tax,
        ];
    }

    /**
     * Release space from order.
     *
     * @return bool|null
     */
    public function release(): ?bool
    {
        if ($this->order()->exists()) {
            $this->order->delete();
        }

        return $this->update(['reserved_at' => null]);
    }

    /**
     * Get the order the space is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Get the user the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
