<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DefaultAuthorizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(config('roles'))->each(function ($role) {
            $role = Role::create($role);
        });

        collect(config('defaults.users.permissions'))
            ->each(function (string $permission): void {
                [$role, $label] = explode(':', $permission);

                $permission = Permission::firstOrCreate(['label' => $label]);

                $role = Role::whereSlug($role)->first();

                if (! is_null($role)) {
                    $role->allowTo($permission);
                }
            });
    }
}
