<?php

use Faker\Generator as Faker;

$factory->define(App\LocationType::class, function (Faker $faker) {
    $icons = [
        'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png',
        'https://maps.google.com/mapfiles/kml/shapes/library_maps.png',
        'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png',
        'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
    ];
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->paragraph,
        'image_id' => factory(\App\Image::class)->states('rectangle')->create()->id,
        'season_start' => $faker->date(),
        'season_finish' => $faker->date(),
        'icon' => $faker->randomElement($icons)
    ];
});
