<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Cratespace\Preflight\Models\Role;
use Cratespace\Preflight\Models\Permission;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->createUser();

        $this->assignDefualtRoles($user);

        $user->createAsBusiness($this->businessDetails());
    }

    /**
     * Create a user with the given default credentials.
     *
     * @return \App\Models\User
     */
    protected function createUser(): User
    {
        return User::create(config('defaults.users.credentials'));
    }

    /**
     * Assign all default roles to the user.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function assignDefualtRoles(User $user): void
    {
        $roles = $this->createRolesWithPermissions();

        $roles->each(function (Role $role) use ($user): void {
            $user->assignRole($role);
        });
    }

    /**
     * Create and allow roles with relative permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function createRolesWithPermissions(): Collection
    {
        return collect(config('defaults.users.roles'))->map(function (array $role): Role {
            $role = Role::create($role);

            $permissions = config("defaults.users.permissions.{$role->name}");

            if (! is_null($permissions)) {
                collect($permissions)->each(function (string $permission) use ($role): void {
                    $permission = Permission::create(['label' => $permission]);

                    $role->allowTo($permission);
                });
            }

            return $role;
        })->values();
    }

    /**
     * Get the default user profile details.
     *
     * @return array
     */
    protected function businessDetails(): array
    {
        return config('defaults.users.profile');
    }
}
