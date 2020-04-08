<?php

use App\Models\User;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'username' => 'Thavarshan',
            'name' => 'Thavarshan Thayananthajothy',
            'email' => 'tjthavarshan@gmail.com',
            'phone' => '775018795',
            'email_verified_at' => now(),
            'password' => Hash::make('alphaxion77'),
            'remember_token' => Str::random(10),
            'type' => 'business',
            'settings' => [
                'notifications_mobile' => 'everything',
                'notifications_email' => [
                    'new-order', 'cancel-order', 'newsletter'
                ],
            ],
        ]);

        $company = Business::create([
            'user_id' => $user->id,
            'name' => 'Cratespace',
            'slug' => 'cratespace',
            'description' => $faker->sentence(7),
            'street' => '22 Auburn Side',
            'city' => 'Sri Lanka',
            'state' => 'Western',
            'country' => 'Sri Lanka',
            'postcode' => 13500,
            'email' => 'tjthavarshan@gmail.com',
            'phone' => '775018794',
        ]);

        Account::create([
            'user_id' => $user->id,
            'credit' => 0
        ]);
    }
}
