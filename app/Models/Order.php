<?php

namespace App\Models;

use App\Models\Traits\Directable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Purchases\Order as OrderContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements OrderContract
{
    use HasFactory;
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
        'confirmation_number',
        'name',
        'email',
        'phone',
        'business',
        'price',
        'tax',
        'total',
        'note',
        'space_id',
        'user_id',
        'customer_id',
    ];

    /**
     * Get the space the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    /**
     * Get the business the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the customer the order belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string
    {
        return 'TODO';
    }

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->space->release();

        $this->delete();
    }
}
