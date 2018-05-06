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
        ->middleware(['confirmation_token.expired', 'guest.api'])
        ->name('activate');

    Route::post('login/oauth', 'SocialLoginController@login')
        ->name('login.oauth');
});


Route::group(['prefix' => 'location', 'as' => 'location.', 'namespace' => 'Maps'], function(){
    /**
     * Display location on google maps
     */
    Route::get('', 'LocationController@index')->name('index');
    Route::post('', 'LocationController@store')->name('store');
    Route::put('', 'LocationController@update')->name('update');
    Route::get('/search/{search}', 'LocationController@search')->name('search');
    Route::get('{location}/show', 'LocationController@show')->name('show');

    Route::group(['prefix' => 'feedback', 'as' => 'feedback.', 'middleware' => ['Auth:api']], function(){
        Route::post('{location}', 'LocationFeedbackController@store')->name('store');
        Route::put('{feedback}/edit', 'LocationFeedbackController@update')
            ->middleware('user.owns.feedback')
            ->name('update');
        Route::delete('{feedback}', 'LocationFeedbackController@destroy')
            ->middleware('user.owns.feedback')
            ->name('delete');
    });

    Route::group(['prefix' => 'favourite', 'as' => 'favourite.', 'middleware' => ['Auth:api']], function(){
        Route::get('', 'LocationFavouriteController@index')->name('index');
        Route::post('', 'LocationFavouriteController@store')->name('store');
    });

    /**
     * Displays Location Type Information
     */
    Route::get('types/', 'LocationTypeController@index')->name('type.index');
    Route::get('types/{locationType}/show', 'LocationTypeController@show')->name('type.show');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Profile', 'middleware' => 'Auth:api'], function(){
    Route::post('', 'ProfileController@store')->name('update');
    Route::post('password', 'PasswordController@store')->name('password');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['Auth:api', 'auth.admin']], function(){
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('', 'AdminUserController@index')->name('index');
        Route::post('admin-access', 'AdminAccessController@store')->name('access')->middleware('auth');
        Route::get('{user}/show', 'AdminUserController@show')->name('show');
    });

    Route::group(['prefix' => 'location-types', 'as' => 'location.'], function(){
        Route::post('', 'AdminLocationTypeController@store')
            ->name('type.store');
        Route::post('encyclopedia', 'AdminLocationTypeEncyclopediaController@remove')
            ->name('type.encyclopedia.remove');
        Route::post('encyclopedia\{locationType}', 'AdminLocationTypeEncyclopediaController@add')
            ->name('type.encyclopedia.add');
        Route::post('{locationType}', 'AdminLocationTypeController@update')
            ->name('type.update');
        Route::delete('{locationType}', 'AdminLocationTypeController@destroy')
            ->name('type.delete');
    });

});
