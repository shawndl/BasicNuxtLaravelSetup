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
        'is_private' => $faker->boolean,
        'description' => $faker->paragraph,
        'latitude' => $faker->latitude(-14.847844, -39.832748),
        'longitude' => $faker->longitude(112.193750, 135.045313)
    ];
});


$factory->state(App\Location::class, 'no-image', function (Faker $faker) {
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
        'image_id' => null,
        'is_private' => $faker->boolean,
        'description' => $faker->paragraph,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});
