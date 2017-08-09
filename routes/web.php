<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/bmi', 'BmiController@index')->name('bmi.index');
Route::get('/about', 'AboutController@index')->name('about.index');
