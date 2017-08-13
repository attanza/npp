<?php

// Auth::routes();
// Main Menu
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rumah-negeri-para-pemimmpi', 'HomeController@index')->name('home');
Route::get('/berjuta-mimpi-indonesia', 'BmiController@index')->name('bmi.index');
Route::get('/tentang-negeri-para-pemimmpi', 'AboutController@index')->name('about.index');

// Auths
Route::get('/login', 'HomeController@index')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

// Dream without middleware
Route::post('/dream/listing', 'DreamController@dreamList');

// NPP Auth
Route::group(['namespace' => 'NppAuth'], function () {
    Route::post('npp-login', 'LoginController@postLogin')->name('npp-login');
    Route::post('npp-register', 'RegisterController@register')->name('npp-register');
    Route::get('npp-activation/{email}/{code}', 'ActivationController@activate')->name('npp-activation');
    Route::post('npp-activation/resend', 'ActivationController@resendActivation')->name('npp-activation.resend');
});

// Auth middleware
Route::group(['middleware' => 'auth'], function(){
    // Profile
    Route::get('profile/{username}', 'ProfileController@show')->name('profile');
});

Route::get('/test/email/layout', function(){
    $user = App\User::with('activation')->find(1);
    return view('mails.after_change_password_mail')->withUser($user);
});

Route::get('/test/data', function(){
    $dream = App\Models\Dream::find(4);
    return $dream;
});
