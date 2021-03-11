<?php

namespace App\Models\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthorization
{
    /**
     * Determine if user is assigned the given role.
     *
     * @return bool
     *
     * @param mixed $role
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            $role = $this->findRole($role);
        }

        return $this->role->is($role);
    }

    public function assignRole($role): void
    {
        if (is_string($role)) {
            $role = $this->findRole($role);
        }

        $this->update(['role_id' => $role->id]);
    }

    public function findRole(string $role): Role
    {
        return Role::whereName($role)->first();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
