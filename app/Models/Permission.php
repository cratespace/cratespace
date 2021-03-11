<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cratespace\Preflight\Contracts\Permission as PermissionContract;

class Permission extends Model implements PermissionContract
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Determine if any permissions have been registered with Preflight.
     *
     * @return bool
     */
    public static function hasPermissions(): bool
    {
        return true;
    }

    /**
     * Return the permissions in the given list that are actually defined permissions for the application.
     *
     * @param array $permissions
     *
     * @return array
     */
    public static function validPermissions(array $permissions): array
    {
        return [];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
