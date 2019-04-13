<?php

use Faker\Generator as Faker;

$factory->define(App\Rank::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(1),
        'image' => $faker->imageUrl(480, 240, 'cats', true),
        'game_id' => rand(1, 5),
    ];
});
