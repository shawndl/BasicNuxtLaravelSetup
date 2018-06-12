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
        ->middleware(['guest.api', 'user.confirmed', 'user.banned'])
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
    Route::post('', 'LocationController@store')
        ->middleware('Auth:api')
        ->name('store');
    Route::post('{location}', 'LocationController@update')
        ->middleware(['Auth:api', 'user.owns.location'])
        ->name('update');
    Route::delete('{location}', 'LocationController@destroy')
        ->middleware(['Auth:api', 'user.owns.location'])
        ->name('delete');
    Route::get('{location}/show', 'LocationController@show')->name('show');

    Route::group(['prefix' => 'feedback', 'as' => 'feedback.', 'middleware' => ['Auth:api']], function(){
        Route::post('{location}', 'LocationFeedbackController@store')
            ->name('store');
        Route::put('{feedback}/edit', 'LocationFeedbackController@update')
            ->middleware('user.owns.feedback')
            ->name('update');
        Route::delete('{feedback}', 'LocationFeedbackController@destroy')
            ->middleware('user.owns.feedback')
            ->name('delete');
    });

    /**
     * Displays Location Type Information
     */
    Route::get('types/', 'LocationTypeController@index')->name('type.index');
    Route::get('types/{locationType}/show', 'LocationTypeController@show')->name('type.show');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => 'Auth:api'], function(){
    Route::post('', 'Profile\ProfileController@store')->name('update');
    Route::post('password', 'Profile\PasswordController@store')->name('password');


    Route::group(['prefix' => 'favourite', 'as' => 'favourite.'], function(){
        Route::get('', 'Maps\LocationFavouriteController@index')->name('index');
        Route::post('', 'Maps\LocationFavouriteController@store')->name('store');
    });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['Auth:api', 'auth.admin']], function(){
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('', 'AdminUserController@index')->name('index');
        Route::post('admin-access', 'AdminAccessController@store')
            ->name('access');
        Route::post('banned', 'AdminAccessController@banned')
            ->name('banned');
        Route::get('{user}/show', 'AdminUserController@show')
            ->name('show');
    });

    Route::group(['prefix' => 'locations', 'as' => 'location.'], function(){
        Route::get('', 'AdminLocationController@index')
            ->name('index');
        Route::delete('{location}', 'AdminLocationController@destroy')
            ->name('delete');

        Route::group(['prefix' => 'location-types', 'as' => 'type.'], function(){
            Route::post('', 'AdminLocationTypeController@store')
                ->name('store');
            Route::post('encyclopedia', 'AdminLocationTypeEncyclopediaController@remove')
                ->name('encyclopedia.remove');
            Route::post('encyclopedia\{locationType}', 'AdminLocationTypeEncyclopediaController@add')
                ->name('encyclopedia.add');
            Route::post('{locationType}', 'AdminLocationTypeController@update')
                ->name('update');
            Route::delete('{locationType}', 'AdminLocationTypeController@destroy')
                ->name('delete');
        });
    });



});
