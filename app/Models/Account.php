<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use App\Models\Traits\Fillable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Fillable;
    use HasUid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit', 'bank_acount_number', 'bank', 'user_id',
    ];

    /**
     * Set the account balance in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setCrediteAttribute($value)
    {
        $this->attributes['credit'] = $value * 100;
    }

    /**
     * Get the books's price.
     *
     * @param string $value
     *
     * @return string
     */
    public function getCrediteAttribute($value)
    {
        return $value / 100;
    }

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
