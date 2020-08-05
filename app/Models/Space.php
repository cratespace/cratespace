<?php

namespace App\Models;

use Carbon\Carbon;
use App\Filters\Filter;
use App\Support\Formatter;
use App\Models\Casts\PriceCast;
use App\Models\Traits\Filterable;
use App\Models\Traits\Searchable;
use App\Models\Casts\ScheduleCast;
use App\Models\Traits\Presentable;
use App\Contracts\Models\Priceable;
use App\Contracts\Models\Statusable;
use App\Models\Concerns\GeneratesUID;
use App\Models\Concerns\ManagesPricing;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GetsPathToResource;

class Space extends Model implements Statusable, Priceable
{
    use Filterable;
    use Presentable;
    use ManagesPricing;
    use GetsPathToResource;
    use GeneratesUID;
    use Searchable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
        'price' => PriceCast::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'departs_at', 'arrives_at', 'height', 'width', 'length',
        'weight', 'note', 'price', 'tax', 'user_id', 'origin', 'destination',
        'type', 'base',
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
     * Determine status of space.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->isAvailable()) {
            return 'Available';
        } elseif (
            $this->hasOrder() ||
            ($this->isExpired() && $this->hasOrder())
        ) {
            return 'Ordered';
        }

        return 'Expired';
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
        return Business::select('name')
            ->whereUserId($this->user_id)
            ->first()
            ->name;
    }

    /**
     * Determine if the resource is available to perform an action on.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if (!$this->isExpired()) {
            return !$this->hasOrder();
        }

        return false;
    }

    /**
     * Determine if the space is associated with an order.
     *
     * @return bool
     */
    public function hasOrder(): bool
    {
        if (is_null($this->order_id)) {
            return $this->order()->exists();
        }

        return $this->order_id ? true : false;
    }

    /**
     * Determine if the space departure date is close or has passed.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->departs_at <= Carbon::now();
    }

    /**
     * Get all spaces associated with the currently authenticated business.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param \App\Filters\Filter                $filters
     * @param string|null                        $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfBusiness($query, Filter $filters, ?string $search = null)
    {
        $query->addSelect([
                'order_id' => Order::select('uid')
                    ->whereColumn('space_id', 'spaces.id')
                    ->latest()
                    ->take(1),
            ])
            ->whereUserId(user('id'))
            ->filter($filters)
            ->search($search)
            ->latest('created_at');
    }

    public function scopeDeparting($query)
    {
        return $query->addSelect([
            'business' => Business::select('name')
                ->whereColumn('user_id', 'spaces.user_id')
                ->latest()
                ->take(1),
            ])
            ->whereDate('departs_at', '=', Carbon::now())
            ->latest('departs_at');
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
                ->latest()
                ->take(1),
            ])
            ->whereDate('departs_at', '>', Carbon::now())
            ->doesntHave('order')
            ->latest();
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Get full url to order page.
     *
     * @return string
     */
    public function path(): string
    {
        return route('spaces.show', $this);
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
}
