<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 50)->make();
        factory(App\User::class, 50)->create();
            // $user->friends()->save(factory(App\User::class)->make());
            // $user->users()->save(factory(App\User::class)->make());
        // });
    }
}
