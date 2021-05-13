<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $fillable = [
        'service_id',
        'pm_type',
        'pm_last_four',
        'user_id',
    ];

    /**
     * Get the user this profile belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user account the customer profile belongs to.
     *
     * @return \App\Models\User|null
     */
    public function account(): ?User
    {
        return $this->user;
    }
}
