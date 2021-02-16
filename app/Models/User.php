<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cratespace\Sentinel\Models\Traits\HasApiTokens;
use Cratespace\Sentinel\Models\Traits\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cratespace\Sentinel\Models\Concerns\InteractsWithSessions;
use Cratespace\Sentinel\Models\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use InteractsWithSessions;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'username',
        'settings',
        'locked',
        'profile_photo_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'sessions',
        'two_factor_enabled',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['business'];

    /**
     * Get business details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'user_id');
    }
}
