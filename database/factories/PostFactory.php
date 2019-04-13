<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    $visibility = ['public', 'private'];
    return [
        'title' => $faker->sentence(3),
        'content' => "<h1>New content !</h1>",
        'image' => $faker->imageUrl(480, 480, 'cats', true),
        'visibility' => $visibility[rand(0, 1)],
    ];
});
