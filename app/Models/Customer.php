<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'user_id'];

    /**
     * Get the business customer details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        if (!is_null($this->user_id)) {
            return $this->belongsTo(User::class, 'user_id');
        }
    }

    /**
     * Get all replies associated with the support ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'customer_id')->latest();
    }
}
