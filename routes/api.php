<?php

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});

Route::get('weather', 'HomeController@weather');
Route::get('feed', 'HomeController@feed');

Route::group(['prefix'=>'v1','namespace'=>'API\V1'], function() {

    // CRUD MANAGERS
    route::resource('managers', 'ManagerController', ['except'=> 'create', 'edit']);

});
