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
        $players = factory(App\User::class, 10)
            ->create()
            ->each(function($u) {
                $u->games()->save(factory(App\Game::class)->create());
            });
        
        // Teams
        $teams = factory(App\Team::class, 5)->create();
        $teams[0]->players()->attach($players[0]->id, ['captain' => true]);
        $teams[0]->players()->attach($players[1]->id);
        $teams[1]->players()->attach($players[2]->id, ['captain' => true]);
        $teams[2]->players()->attach($players[3]->id, ['captain' => true]);
        $teams[3]->players()->attach($players[4]->id, ['captain' => true]);
        $teams[4]->players()->attach($players[5]->id, ['captain' => true]);

        // Tournaments
        factory(App\Tournament::class, 5)->create();

        // Posts
        factory(App\Post::class, 5)->create();

        // Rules
        factory(App\Rule::class)->create();
    }
}
