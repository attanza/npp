<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user-data', 'UserController@getUser');
    Route::put('/profile/{id}', 'ProfileController@update');
    Route::put('/profile/{id}/detail', 'ProfileController@updateDetail');
    Route::post('/profile/upload/{id}', 'ProfileController@uploadAvatar');  
});
