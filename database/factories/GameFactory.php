<?php

use Faker\Generator as Faker;

$factory->define(App\Game::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'image' => $faker->imageUrl(640, 480, 'cats', true),
    ];
});
