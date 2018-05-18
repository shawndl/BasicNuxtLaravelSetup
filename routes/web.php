<?php


Route::get('/', function() {
    $location = \App\Location::limit(10)->get();
    $user = \App\User::find(21);

    foreach ($location as $l)
    {
        $l->addFavourite($user);
    }
});
