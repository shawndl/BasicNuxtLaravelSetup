<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Location::class, 20)
            ->create()
            ->each(function ($location) {
                factory(\App\Feedback::class, 5)
                    ->create([
                        'feedback_id' => $location,
                        'feedback_type' => 'App\Location'
                    ]);
                factory(\App\Favourite::class, 5)
                    ->create([
                        'favourite_id' => $location,
                        'favourite_type' => 'App\Location'
                    ]);
            });
    }
}
