<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilter extends Filter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
<<<<<<< HEAD
    protected $filters = ['author', 'popular', 'unanswered'];
=======
    protected $filters = ['by', 'popular', 'unanswered'];
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

    /**
     * Filter the query by a given username.
     *
     * @param string $username
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
<<<<<<< HEAD
    protected function author($username)
=======
    protected function by($username)
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    {
        return $this->builder->where(
            'user_id',
            User::where('name', $username)->firstOrFail()->id
        );
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Filter the query according to those that are unanswered.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
