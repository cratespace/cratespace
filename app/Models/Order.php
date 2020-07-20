<?php

namespace App\Models;

use App\Support\Formatter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\CalculatesCharges;

class Order extends Model
{
    use CalculatesCharges;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_id', 'name', 'email', 'phone', 'business',
        'service', 'price', 'tax',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total'];

    /**
     * Get total amount charged for order placement.
     *
     * @return string
     */
    public function getTotalAttribute()
    {
        return Formatter::moneyFormat($this->totalInCents());
    }

    /**
     * Get the total amount to be charged in cents.
     *
     * @return int
     */
    public function totalInCents(): int
    {
        return $this->price + $this->service + $this->tax;
    }

    /**
     * Calculate service charge amount.
     *
     * @return int
     */
    public function getServiceCharge(): int
    {
        return $this->space->getFullPriceInCents() * config('charges.service');
    }

    /**
     * Get the space associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    /**
     * Delete order instance.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->space->release();

        $this->delete();
    }
}
