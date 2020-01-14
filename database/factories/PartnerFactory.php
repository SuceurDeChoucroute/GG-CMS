<?php

use Faker\Generator as Faker;

$factory->define(App\Partner::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'site' => $faker->url,
        'logo' => $faker->imageUrl(85, 85),
    ];
});
