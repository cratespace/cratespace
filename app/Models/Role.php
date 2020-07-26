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
     * Allow an ability to the role.
     *
     * @param \App\Models\Ability $ability
     *
     * @return void
     */
    public function allowTo(Ability $ability): void
    {
        $this->abilities()->sync($ability);
    }
}
