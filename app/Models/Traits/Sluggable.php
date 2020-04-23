<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Boot sluggable trait.
     */
    protected static function bootSluggable()
    {
        static::creating(function ($model) {
            $model->slug = $model->title ?? $model->name;
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }
}
