<?php

namespace App\Models;

use App\Models\Traits\ManageRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cratespace\Sentinel\Models\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    use ManageRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'settings',
        'locked',
        'profile_photo_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'role_id',
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
        'role_id',
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
        'profile',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['role'];

    /**
     * Get the appropriate user profile.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProfileAttribute(): Model
    {
        return $this->business ?? $this->customer;
    }

    /**
     * Get business details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'user_id');
    }

    /**
     * Get customer details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

    /**
     * Get business details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces(): HasMany
    {
        return $this->hasMany(Space::class, 'user_id');
    }
}
