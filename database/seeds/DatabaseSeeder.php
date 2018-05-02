<?php

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Thread::class, 50)->create()->each(function ($thread) {
            factory(Reply::class, 3)->create(['thread_id' => $thread->id]);
        });

        collect([
            [
                'email' => 'aa+2@ak-ventures.eu',
                'name' => 'amade2',
                'confirmed' => true,
                'password' => bcrypt('secret'),
            ],
            [
                'email' => 'aa@ak-ventures.eu',
                'name' => 'amade',
                'confirmed' => true,
                'password' => bcrypt('secret'),
            ]
        ])->each(function ($user) {
            User::create($user);
        });
    }
}
