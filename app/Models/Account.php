<?php

namespace App\Models;

use App\Models\Traits\Indexable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Indexable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit', 'bank_acount_number', 'bank_account_name',
        'bank_name', 'user_id',
    ];

    /**
     * Get the user associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
