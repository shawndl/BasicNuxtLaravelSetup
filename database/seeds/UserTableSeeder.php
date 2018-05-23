<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 100)
            ->create();

        $user = factory(\App\User::class)->create([
            'name' => 'test',
            'email' => 'test@gmail',
            'password' => bcrypt('secret'),
            'is_active' => 1
        ]);

        $role = factory(\App\Role::class)->create([
           'name' => 'admin'
        ]);

        $user->roles()->attach($role);
    }
}
