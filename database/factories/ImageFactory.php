<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'path' => $faker->imageUrl(200, 300)
    ];
});

$factory->state(App\Image::class, 'rectangle', function (Faker $faker) {
    return [
        'path' => $faker->imageUrl(150, 150)
    ];
});
