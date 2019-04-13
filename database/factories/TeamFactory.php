<?php

use Faker\Generator as Faker;

$factory->define(App\Team::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'avatar' => $faker->imageUrl(480, 480, 'cats', true),
        'game_id' => rand(1, 5),
    ];
});
