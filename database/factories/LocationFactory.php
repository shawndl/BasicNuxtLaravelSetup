<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'location_type_id' => function() use ($faker) {
            if(\App\LocationType::count() > 0) {
                return $faker->randomElement(\App\LocationType::pluck('id')->toArray());
            }
            return factory(\App\LocationType::class)->create()->id;
        },
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'lat' => $faker->latitude,
        'long' => $faker->longitude
    ];
});
