<?php

use Illuminate\Database\Seeder;

class LocationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\LocationType::class, 20)->create()
            ->each(function ($type) {
                $type->addLink('https://www.google.com/', str_random(6));
            });
    }
}
