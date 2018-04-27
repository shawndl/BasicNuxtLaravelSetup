<?php

use Faker\Generator as Faker;

$factory->define(App\Feedback::class, function (Faker $faker) {
    return [
        'user_id' => function() use ($faker) {
            if(\App\User::count() > 0) {
                return $faker->randomElement(\App\User::pluck('id')->toArray());
            }
            return factory(\App\User::class)->create()->id;
        },
        'location_id' => function() use ($faker) {
            if(\App\Location::count() > 0) {
                return $faker->randomElement(\App\Location::pluck('id')->toArray());
            }
            return factory(\App\Location::class)->create()->id;
        },
        'comment' => $faker->paragraph,
        'review' => rand(1, 5),
    ];
});
