<?php

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

if (!function_exists('business')) {
    /**
     * Get the authenticated business account and/or attributes.
     *
     * @param string|null $attribute
     *
     * @return string|null
     */
    function business(?string $attribute = null)
    {
        if (!user()->isType(['business'])) {
            return null;
        }

        if (!is_null($attribute)) {
            return user('business')->{$attribute};
        }

        return user()->business();
    }
}

if (!function_exists('greet')) {
    /**
     * Greet user according to user's time.
     *
     * @return string
     */
    function greet(): string
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

if (!function_exists('parse')) {
    /**
     * Parse markdown.
     *
     * @param string $content
     *
     * @return string
     */
    function parse(string $content): string
    {
        return app('markdown.parser')->text($content);
    }
}

if (!function_exists('get_excerpt')) {
    /**
     * Trim large text body to size of an excerpt.
     *
     * @param string $content
     * @param int    $length
     *
     * @return string
     */
    function get_excerpt(string $content, int $length = 255): string
    {
        $content = preg_split('/<!-- more -->/m', $content, 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $content[0];
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    }
}
