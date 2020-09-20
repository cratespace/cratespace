<?php

namespace App\Models;

use App\Models\Traits\Indexable;
use App\Models\Casts\SettingsCast;
use App\Models\Traits\Presentable;
use App\Models\Traits\Redirectable;
use App\Models\Traits\HasProfilePhoto;
use App\Models\Concerns\ManagesSessions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Concerns\ManagesRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasProfilePhoto;
    use ManagesRolesAndAbilities;
    use Presentable;
    use Indexable;
    use Redirectable;
    use ManagesSessions;

    /**
     * Preferred route key name.
     *
     * @var string
     */
    protected static $routeKey = 'username';

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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => SettingsCast::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the user's business details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business()
    {
        return $this->hasOne(Business::class, 'user_id');
    }

    /**
     * Get the user's account details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'user_id');
    }

    /**
     * Get all spaces associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany(Space::class)->latest();
    }

    /**
     * Get all support tickets assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        if ($this->hasRole('support-agent')) {
            return $this->hasMany(Ticket::class, 'agent_id');
        }
    }

    /**
     * Get all replies associated with the support ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        if ($this->hasRole('support-agent')) {
            return $this->hasMany(Reply::class, 'agent_id')->latest();
        }
    }
}
