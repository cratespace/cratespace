<?php

namespace App\Models\Concerns;

use App\Models\Role;

trait ManagesRolesAndAbilities
{
    /**
     * Get all abilities the user is authorized to have.
     *
     * @return \Illuminate\Support\Collection
     */
    public function abilities()
    {
        return $this->roles
            ->map
            ->abilities
            ->flatten()
            ->pluck('title')
            ->unique();
    }

    /**
     * Get all roles assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Assign a new role to the user.
     *
     * @param mixed $role
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereTitle($role)->firstOrFail();
        }

        $this->roles()->sync($role, false);
    }

    /**
     * Determine if the user has the given role.
     *
     * @param string $title
     *
     * @return bool
     */
    public function hasRole(string $title): bool
    {
        return $this->roles->contains(
            Role::whereTitle($title)->first()
        );
    }

    /**
     * Determine if the user has the given ability.
     *
     * @param string $title
     *
     * @return bool
     */
    public function hasAbility(string $title): bool
    {
        return $this->abilities()->contains($title);
    }
}
