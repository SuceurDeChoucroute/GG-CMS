<?php

use Faker\Generator as Faker;

$factory->define(App\Tournament::class, function (Faker $faker) {
    $status = [
        'Open',
        'Closed',
        'Finished',
    ];

    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'game_id' => rand(1,5),
        'start_date' => '1999-01-01',
        'end_date' => '1999-01-02',
        'places' => rand(6, 24),
        'cashprize' => rand(150, 1000),
        'status' => $status[rand(0,2)],
        'image' => $faker->imageUrl(640, 480, 'cats', true),
    ];
});
