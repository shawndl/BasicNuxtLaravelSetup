<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $a = \App\Image::first();
    dd($a->path);
//    factory(\App\LocationType::class, 10)->create();
//    factory(\App\Role::class)->create(['name' => 'admin']);
//    factory(\App\User::class)->create(['email' => 'test@gmail.com', 'password' => bcrypt('aaaaaa')]);

    return view('welcome');
});
