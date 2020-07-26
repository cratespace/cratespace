<?php

use App\Models\Role;
use App\Models\Ability;
use Illuminate\Database\Seeder;

class RolesAbilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultAbilities();

        $this->createDefaultRoles();
    }

    /**
     * Create default abilities of users.
     *
     * @return void
     */
    protected function createDefaultAbilities(): void
    {
        foreach (config('roles-abilities.abilities') as $ability) {
            Ability::create($ability);
        }
    }

    /**
     * Create default roles of users.
     *
     * @return void
     */
    protected function createDefaultRoles(): void
    {
        foreach (config('roles-abilities.roles') as $ability) {
            Role::create($ability);
        }
    }
}
