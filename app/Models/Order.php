<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

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
     * Get full path to single resource page.
     *
     * @return string
     */
    public function getPathAttribute(): string
    {
        return route('orders.show', $this);
    }
}
