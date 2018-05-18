<?php

use Faker\Generator as Faker;

$factory->define(App\Favourite::class, function (Faker $faker) {
    return [
        'user_id' => function() use ($faker) {
            if(\App\User::count() > 0) {
                return $faker->randomElement(\App\User::pluck('id')->toArray());
            }
            return factory(\App\User::class)->create()->id;
        },
        'favourite_type' => \App\Location::class,
        'favourite_id' => function() use ($faker) {
            if(\App\Location::count() > 0) {
                return $faker->randomElement(\App\Location::pluck('id')->toArray());
            }
            return factory(\App\Location::class)->create()->id;
        },
    ];
});
