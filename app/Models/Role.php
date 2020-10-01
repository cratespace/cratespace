<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all abilities associated with the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    /**
     * Grant the given ability to the role.
     *
     * @param mixed $ability
     *
     * @return void
     */
    public function allowTo($ability): void
    {
        if (is_string($ability)) {
            $ability = Ability::whereTitle($ability)->firstOrFail();
        }

        $this->abilities()->sync($ability, false);
    }

    /**
     * Create new role and assign abilities to said role.
     *
     * @param string      $title
     * @param string|null $label
     * @param array       $abilities
     *
     * @return \App\Models\Role
     */
    public static function createAndAssign(string $title, ?string $label = null, array $abilities): Role
    {
        return tap(static::create(compact('title', 'label')), function (Role $role) use ($abilities) {
            collect($abilities)
                ->unique()
                ->sort()
                ->values()
                ->map(function (string $ability) {
                    return Ability::create(['title' => $ability]);
                })
                ->each(function (Ability $ability) use ($role) {
                    $role->allowTo($ability);
                });
        });
    }
}
