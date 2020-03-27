<?php

if (! function_exists('user')) {
    /**
     * Get the authenticated user and/or attributes.
     *
     * @param  string|null $attribute
     * @return string|\Illuminate\Database\Eloquent\Model
     */
    function user($attribute = null)
    {
        if (! is_null($attribute)) {
            return auth()->user()->{$attribute};
        }

        return auth()->user();
    }
}

if (! function_exists('business')) {
    /**
     * Get the authenticated business account and/or attributes.
     *
     * @param  string|null $attribute
     * @return string|\Illuminate\Database\Eloquent\Model
     */
    function business($attribute = null)
    {
        if (! user()->isType(['business'])) {
            return null;
        }

        if (! is_null($attribute)) {
            return user('business')->{$attribute};
        }

        return user()->business();
    }
}

if (! function_exists('greet')) {
    /**
     * Greet user according to user's time.
     */
    function greet()
    {
        $hour = date('G');

        switch ($hour) {
            case $hour >= 5 && $hour <= 11:
                return 'Good Morning';
                break;
            case $hour >= 12 && $hour <= 18:
                return 'Good Afternoon';
                break;
            case $hour >= 19 || $hour <= 4:
                return 'Good Evening';
                break;
        }
    }
}

if (! function_exists('is_active')) {
    /**
     * Determine if the given route is active path.
     *
     * @param  string  $path
     * @param  string  $active
     * @param  string  $default
     * @return bool
     */
    function is_active($path, $active = 'active', $default = '')
    {
        return call_user_func_array('Request::is', (array) $path) ? $active : $default;
    }
}
