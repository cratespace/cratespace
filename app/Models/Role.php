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
     */
    public function allowTo($ability)
    {
        if (is_string($ability)) {
            $ability = Ability::whereTitle($ability)->firstOrFail();
        }

        $this->abilities()->sync($ability, false);
    }
}
