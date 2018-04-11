<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('Auth:api')->get('/User', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function(){
   Route::post('register', 'RegisterController@register')
       ->middleware(['guest.api'])
       ->name('register');
    Route::post('login', 'LoginController@login')
        ->middleware(['guest.api', 'user.confirmed'])
        ->name('login');
    Route::post('/logout', 'LogoutController@logout')->name('logout');
    Route::get('/me', 'MeController@me')
        ->middleware(['Auth:api'])
        ->name('me');
    Route::get('/activate/{confirmation_token}', 'ActivationController@activate')
//        ->middleware(['confirmation_token.expired', 'guest.api'])
        ->name('activate');
});


Route::group(['prefix' => 'location', 'as' => 'location.', 'namespace' => 'Maps'], function(){
    /**
     * Display location on google maps
     */
    Route::get('', 'LocationController@index')->name('index');
    Route::post('', 'LocationController@store')->name('store');
    Route::put('', 'LocationController@update')->name('update');
    Route::get('{location}/show', 'LocationController@show')->name('show');

    /**
     * Displays Location Type Information
     */
    Route::get('', 'LocationTypeController@index')->name('index');
    Route::get('{location}/show', 'LocationTypeController@show')->name('show');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Profile', 'middleware' => 'Auth:api'], function(){
    Route::post('', 'ProfileController@store')->name('update');
    Route::post('password', 'PasswordController@store')->name('password');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth.admin'], function(){
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('', 'AdminUserController@index')->name('index');
        Route::post('admin-access', 'AdminAccessController@store')->name('index');
        Route::get('{user}/show', 'AdminUserController@show')->name('show');
    });
    Route::group(['prefix' => 'location-types', 'as' => 'locationTypes.'], function(){
        Route::post('', 'AdminLocationTypeController@store')->name('store');
        Route::put('{locationType}', 'AdminLocationTypeController@update')->name('update');
    });

});