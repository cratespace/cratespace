<?php

namespace App\Models;

use App\Models\Casts\AddressCast;
use App\Models\Casts\SettingsCast;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\ManagesBusiness;
use App\Models\Concerns\ManagesCustomer;
use Illuminate\Notifications\Notifiable;
use Cratespace\Sentinel\Models\Traits\HasApiTokens;
use Cratespace\Preflight\Models\Concerns\ManagesRoles;
use Cratespace\Sentinel\Models\Traits\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cratespace\Sentinel\Models\Concerns\InteractsWithSessions;
use Cratespace\Sentinel\Models\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasApiTokens;
    use ManagesRoles;
    use ManagesCustomer;
    use ManagesBusiness;
    use HasProfilePhoto;
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
        'password',
        'username',
        'settings',
        'profile',
        'address',
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
        'address' => AddressCast::class,
        'settings' => SettingsCast::class,
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
     * Get the user's profile.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProfileAttribute(): Model
    {
        return $this->hasRole('Business') ? $this->business : $this->customer;
    }
}
