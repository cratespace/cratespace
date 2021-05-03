<?php

namespace Tests\Concers;

use Cratespace\Preflight\Models\Role;

trait CreatesRoles
{
    /**
     * List of default user roles.
     *
     * @var array
     */
    public static $roles = [
        'Administrator' => 'administrator',
        'Business' => 'business',
        'Customer' => 'customer',
    ];

    /**
     * Configure default user roles.
     *
     * @param array $roles
     *
     * @return void
     */
    public static function setRoles(array $roles = []): void
    {
        static::$roles = array_merge(static::$roles, $roles);
    }

    /**
     * Create default user roles.
     *
     * @return void
     */
    public function createDefaultRoles(): void
    {
        foreach (static::$roles as $name => $slug) {
            Role::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
    }
}
