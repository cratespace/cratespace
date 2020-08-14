<?php

namespace App\Auth\Relationships;

use Closure;
use Illuminate\Support\Str;
use App\Contracts\Support\Responsibility;
use App\Models\Business as BusinessModel;

class Business implements Responsibility
{
    /**
     * Handle given data and pass it on to next action.
     *
     * @param array    $data
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(array $data, Closure $next)
    {
        BusinessModel::create([
            'user_id' => $data['user']->id,
            'name' => $data['business'],
            'slug' => Str::slug($data['business']),
        ]);

        return $next($data);
    }
}
