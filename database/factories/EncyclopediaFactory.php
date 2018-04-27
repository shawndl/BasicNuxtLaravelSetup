<?php

use Faker\Generator as Faker;

$factory->define(App\Encyclopedia::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'path' => $faker->url,
        'encyclopedia_id' => 22,
        'encyclopedia_type' => \App\LocationType::class
    ];
});
