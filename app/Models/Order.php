<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Events\OrderStatusUpdated;
use App\Models\Traits\Presentable;
use App\Models\Traits\Redirectable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Presentable;
    use Filterable;
    use Redirectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_id',
        'name',
        'email',
        'phone',
        'business',
        'service',
        'price',
        'tax',
        'total',
        'user_id',
        'status',
        'confirmation_number',
    ];

    /**
     * Update order status.
     *
     * @param string $status
     *
     * @return void
     */
    public function updateStatus(string $status): void
    {
        $this->update(['status' => $status]);

        event(new OrderStatusUpdated($this));
    }

    /**
     * Create new charge details.
     *
     * @param array $data
     *
     * @return \App\Models\Charge
     */
    public function createCharge(array $data): Charge
    {
        return $this->charge()->create($data);
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
     * Get the charge associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function charge()
    {
        return $this->hasOne(Charge::class, 'order_id');
    }

    /**
     * Get the business user associated with this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
