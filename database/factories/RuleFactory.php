<?php

use Faker\Generator as Faker;

$factory->define(App\Rule::class, function (Faker $faker) {
    return [
        'content' => $faker->sentence(50),
    ];
});
