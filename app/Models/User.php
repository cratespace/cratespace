<?php

namespace App\Models;

use App\Models\Traits\HasImage;
use App\Models\Casts\SettingsCast;
use Illuminate\Notifications\Notifiable;
use App\Models\Concerns\ManagesRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasImage;
    use ManagesRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'username',
        'image', 'settings',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

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
}
