<?php

// Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/bmi', 'BmiController@index')->name('bmi.index');
Route::get('/about', 'AboutController@index')->name('about.index');

Route::group(['namespace' => 'NppAuth', 'prefix' => 'npp-login'], function () {
    Route::post('/', 'LoginController@postLogin')->name('npp-login');
});
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
