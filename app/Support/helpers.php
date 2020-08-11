<?php

declare(strict_types=1);

if (!function_exists('user')) {
    /**
     * Get the authenticated user and/or attributes.
     *
     * @param string|null $attribute
     *
     * @return string|null
     */
    function user(?string $attribute = null)
    {
        if (!is_null($attribute)) {
            return auth()->user()->{$attribute};
        }

        return auth()->user();
    }
}

if (!function_exists('is_active')) {
    /**
     * Determine if the given route is active path.
     *
     * @param string $path
     * @param string $active
     * @param string $default
     *
     * @return bool|string
     */
    function is_active(string $path, string $active = 'active', string $default = ''): string
    {
        return call_user_func_array(
            'Request::is',
            (array) $path
        ) ? $active : $default;
    }
}
