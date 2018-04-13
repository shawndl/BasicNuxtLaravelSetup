<?php

use Faker\Generator as Faker;

$factory->define(App\LocationType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->paragraph,
        'season_start' => $faker->date(),
        'season_finish' => $faker->date()
    ];
});
