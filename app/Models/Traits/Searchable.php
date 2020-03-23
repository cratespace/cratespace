<?php

namespace App\Models\Traits;

trait Searchable
{
    /**
     * Filter datatbase query according to given parameters.
     *
     * @param  string $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function search($query)
    {
        $builder = static::where('user_id', user('id'));

        return is_null($query)
            ? $builder
            : $builder->where('uid', 'like', '%'.$query.'%')
                ->orWhere('height', 'like', '%'.$query.'%')
                ->orWhere('width', 'like', '%'.$query.'%')
                ->orWhere('length', 'like', '%'.$query.'%')
                ->orWhere('origin', 'like', '%'.$query.'%')
                ->orWhere('destination', 'like', '%'.$query.'%');
    }

    /**
     * Fetch all model attributes that will be searched.
     *
     * @return array
     */
    protected static function getAttributesToSearch()
    {
        if (isset(static::$searchableColumns)) {
            return static::$searchableColumns;
        }

        return ['name'];
    }
}
