<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user-data', 'UserController@getUser');
    // Profile
    Route::put('/profile/{id}', 'ProfileController@update');
    Route::put('/profile/{id}/detail', 'ProfileController@updateDetail');
    Route::post('/profile/upload/{id}', 'ProfileController@uploadAvatar');
    // Password Utility
    Route::post('/reset-password/{id}', 'PasswordUtilityController@resetPassword');
    // Dream
    Route::post('/dream/{id}', 'DreamController@storeDream');
    Route::post('/dream/{id}/upload', 'DreamController@uploadDreamPhoto');
    // Comments
    Route::post('comment', 'DreamCommentController@store');
    // orders
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
      Route::group(['prefix' => 'orders'], function(){
        Route::post('/listing', 'OrderController@listing');
      });
    });
    // Boost
    Route::get('boost/{id}', 'BoostController@giveBoost');

});
