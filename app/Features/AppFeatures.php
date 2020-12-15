<?php

namespace App\Features;

class AppFeatures extends Features
{
    /**
     * Prefix of application category.
     *
     * @var string
     */
    protected static $prefix = 'app';

    /**
     * Enable API token feature.
     *
     * @return string
     */
    public static function apiToken(): string
    {
        return 'api-token';
    }

    /**
     * Enable user profile picture feature.
     *
     * @return string
     */
    public static function profilePhoto(): string
    {
        return 'profile-photo';
    }
}
