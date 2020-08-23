<?php

namespace App\Auth\Relationships;

use Closure;
use App\Models\Account as AccountModel;
use App\Contracts\Support\Responsibility;

class Account implements Responsibility
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
        AccountModel::create(['user_id' => $data['user']->id]);

        return $next($data);
    }
}
