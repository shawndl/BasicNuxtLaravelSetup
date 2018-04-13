<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'user_id' => function() use ($faker) {
            if(\App\User::count() > 0) {
                return $faker->randomElement(\App\User::pluck('id')->toArray());
            }
            return factory(\App\User::class)->create()->id;
        },
        'location_type_id' => function() use ($faker) {
            if(\App\LocationType::count() > 0) {
                return $faker->randomElement(\App\LocationType::pluck('id')->toArray());
            }
            return factory(\App\LocationType::class)->create()->id;
        },
        'image_id' => factory(\App\Image::class)->create()->id,
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});
