<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use App\Models\Traits\Fillable;
use App\Models\Concerns\GeneratesUid;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Fillable, HasUid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit', 'bank_acount_number', 'bank', 'user_id',
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
