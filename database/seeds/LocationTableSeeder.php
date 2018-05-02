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
        factory(\App\Location::class, 100)
            ->create()
            ->each(function ($location) {
                factory(\App\Feedback::class, 5)
                    ->create([
                        'feedback_id' => $location,
                        'feedback_type' => 'App\Location'
                    ]);
            });
    }
}
