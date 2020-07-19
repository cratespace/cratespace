<?php

namespace App\Models;

use Carbon\Carbon;
use App\Support\Formatter;
use App\Models\Traits\Filterable;
use App\Models\Traits\Presentable;
use App\Contracts\Models\Statusable;
use App\Models\Concerns\ManagesStatus;
use Illuminate\Database\Eloquent\Model;

class Space extends Model implements Statusable
{
    use Filterable;
    use Presentable;
    use ManagesStatus;

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
     * Set the space's price in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Get the space's price.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return Formatter::moneyFormat($value);
    }

    /**
     * Set the space's price in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = $value * 100;
    }

    /**
     * Get the space's tax amount.
     *
     * @param string $value
     *
     * @return string
     */
    public function getTaxAttribute($value)
    {
        return Formatter::moneyFormat($value);
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
     * Get price as integer and in cents.
     *
     * @return int
     */
    public function getPriceInCents(): int
    {
        return Formatter::getIntegerValues($this->price);
    }

    /**
     * Get tax as integer and in cents.
     *
     * @return int
     */
    public function getTaxInCents(): int
    {
        return Formatter::getIntegerValues($this->tax);
    }

    /**
     * Get full price as integer and in cents.
     *
     * @return int
     */
    public function getFullPriceInCents(): int
    {
        return $this->getPriceInCents() + $this->getTaxInCents();
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
     * Get full path to resource page.
     *
     * @return string
     */
    public function path(): string
    {
        return route('spaces.show', $this);
    }

    /**
     * Determine if the resource is available to perform an action on.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->departs_at > Carbon::now()) {
            return !$this->order()->exists();
        }

        return false;
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
            ->whereStatus('Available')
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
}
