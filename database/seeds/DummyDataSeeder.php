<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Reply;
use App\Models\Space;
use App\Models\Thread;
use App\Models\Profile;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create(Space::class, ['user_id' => 1], 20);

        create(Thread::class, [], 5)->each(function ($thread) {
            create(Reply::class, ['user_id' => $thread->user->id, 'thread_id' => $thread->id], 7);
        });
    }
}
