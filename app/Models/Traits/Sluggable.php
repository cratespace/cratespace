<?php

namespace App\Models\Traits;

use LogicException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    /**
     * Model attribute to use when creating the slug.
     *
     * @var string
     */
    protected $sluggable;

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected static function bootSluggable(): void
    {
        // Auto-create slug during first database entry.
        static::creating(function (Model $model): void {
            // We first check whether the model has an attribute called "slug".
            if (! $model->hasAttribute('slug')) {
                // If it doesn't we skip the slugification process.
                return;
            }

            // Otherwise we which attribute of the model is used to create
            // a slug with and convert into proper slug format the
            // value of the given field.
            $model->slug = $model->sluggableField()->sluggify();
        });

        // Updating slug field when sluggable field is updated.
        static::updating(function (Model $model): void {
            // We first determine if the feild used to create the slug with
            // has been updated.
            if (! $model->isDirty($model->getSluggableField())) {
                // If it has not, we skip this step.
                return;
            }

            // If it has, we update the slug feild accordingly.
            $model->slug = $model->sluggableField()->sluggify();
        });
    }

    /**
     * Name of attribute that will be used to create the slug from.
     *
     * @return string
     */
    public function getSluggableField(): string
    {
        if (property_exists($this, 'sluggableField')) {
            return $this->sluggableField;
        } elseif ($this->hasAttribute('name')) {
            return 'name';
        } elseif ($this->hasAttribute('title')) {
            return 'title';
        }

        throw new LogicException('Property [sluggableField] is not set on model.');
    }

    /**
     * Set sluggable field.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function sluggableField(): Model
    {
        $this->sluggable = $this->{$this->getSluggableField()};

        return $this;
    }

    /**
     * Create slug from set model attribute.
     *
     * @return string
     */
    protected function sluggify(): string
    {
        $slug = Str::slug($this->sluggable);

        if (static::whereSlug($slug)->exists()) {
            $slug = Str::slug($slug . '-' . Str::random(7));
        }

        return $slug;
    }

    /**
     * Determine if the model table has given column.
     *
     * @param string $column
     *
     * @return bool
     */
    protected function hasAttribute(string $column): bool
    {
        return Schema::hasColumn($this->getTable(), $column);
    }
}
