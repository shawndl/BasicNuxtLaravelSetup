<?php

use Faker\Generator as Faker;

$factory->define(App\LocationType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'season_start' => $faker->date(),
        'season_finish' => $faker->date()
    ];
});
