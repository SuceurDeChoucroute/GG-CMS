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
        // Players & Games
        factory(App\User::class, 10)
            ->create()
            ->each(function($u) {
                $u->games()->save(factory(App\Game::class)->create());
            });
    }
}
