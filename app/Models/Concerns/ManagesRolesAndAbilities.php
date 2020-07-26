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
     * Assign a role to the user.
     *
     * @param \App\Models\Role $role
     *
     * @return void
     */
    public function assignRole(Role $role): void
    {
        $this->roles()->sync($role);
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
