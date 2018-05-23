<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Cache::flush();
        $this->call(UserTableSeeder::class);
        $this->call(LocationTypeTableSeeder::class);
        $this->call(LocationTableSeeder::class);
    }
}
