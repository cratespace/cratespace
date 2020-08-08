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
    use DetectsStatus;
    use Filterable;
    use Presentable;
    use Redirectable;

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
        'uid',
        'departs_at',
        'arrives_at',
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

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
     * Place an order for this space.
     *
     * @param array $data
     *
     * @return \App\Models\Order
     */
    public function placeOrder(array $data): Order
    {
        abort_if(!$this->isAvailable(), 422);

        $order = $this->order()->create($data);

        return $order;
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
