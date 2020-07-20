<?php

namespace App\Models;

use Carbon\Carbon;
use App\Support\Formatter;
use App\Models\Traits\Filterable;
use App\Models\Traits\Presentable;
use App\Contracts\Models\Priceable;
use App\Contracts\Models\Statusable;
use App\Models\Concerns\ManagesStatus;
use App\Models\Concerns\ManagesPricing;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\GetsPathToResource;

class Space extends Model implements Statusable, Priceable
{
    use Filterable;
    use Presentable;
    use ManagesStatus;
    use ManagesPricing;
    use GetsPathToResource;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
    ];

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
        'uid', 'departs_at', 'arrives_at', 'height', 'width', 'length',
        'weight', 'note', 'price', 'tax', 'user_id', 'origin', 'destination',
        'status', 'type', 'base',
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
     * Get charge amount as integer and in cents.
     *
     * @param string|int $amount
     *
     * @return int
     */
    public function getChargeAmountInCents($amount): int
    {
        if (is_string($amount)) {
            return Formatter::getIntegerValues($amount);
        }

        return $amount * 100;
    }

    /**
     * Get the name of the business the space is associated with.
     *
     * @return string
     */
    public function getBusinessNameAttribute()
    {
        return Business::whereUserId($this->user_id)->first()->name;
    }

    /**
     * Determine if the resource is available to perform an action on.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if (!$this->isExpired()) {
            return !$this->order()->exists();
        }

        return false;
    }

    /**
     * Determine if the space departure date is close or has passwed.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->departs_at <= Carbon::now();
    }

    /**
     * Scope a query to only include spaces based in user's country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList($query)
    {
        return $query->addSelect([
            'business' => Business::select('name')
                ->whereColumn('user_id', 'spaces.user_id')
                ->take(1),
            ])
            ->whereDate('departs_at', '>', Carbon::now())
            ->doesntHave('order')
            ->latest();
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

    /**
     * Place an order for this space.
     *
     * @param array $data
     *
     * @return \App\Models\Order
     */
    public function placeOrder(array $data): Order
    {
        abort_if($this->status !== 'Available', 403);

        $order = $this->order()->create($data);

        $this->markAs('Ordered');

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
     * Release the space from an order.
     *
     * @return bool
     */
    public function release(): bool
    {
        if (!$this->isExpired()) {
            return $this->markAs('Available');
        }

        return $this->markAs('Expired');
    }
}
