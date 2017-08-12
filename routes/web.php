<?php

// Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/rumah-negeri-para-pemimmpi', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@index')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/berjuta-mimpi-indonesia', 'BmiController@index')->name('bmi.index');
Route::get('/tentang-negeri-para-pemimmpi', 'AboutController@index')->name('about.index');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['namespace' => 'NppAuth'], function () {
    Route::post('npp-login', 'LoginController@postLogin')->name('npp-login');
    Route::post('npp-register', 'RegisterController@register')->name('npp-register');
    Route::get('npp-activation/{email}/{code}', 'ActivationController@activate')->name('npp-activation');
    Route::post('npp-activation/resend', 'ActivationController@resendActivation')->name('npp-activation.resend');
});

Route::group(['middleware' => 'auth'], function(){
    // Profile
    Route::get('profile/{username}', 'ProfileController@show')->name('profile');
});

Route::get('/test/email/layout', function(){
    $user = App\User::with('activation')->find(1);
    return view('mails.activation_code_mail')->withUser($user);
});
