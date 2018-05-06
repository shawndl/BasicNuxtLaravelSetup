<?php

use Faker\Generator as Faker;

$factory->define(App\Favourite::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'path' => $faker->url,
        'favourite_id' => 22,
        'favourite_type' => \App\Location::class
    ];
});
