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
Route::get('/dream/{slug}', 'DreamController@dreamShow')->name('dream.show');
Route::get('/dream/{slug}/{id}', 'DreamController@dreamRedirector')->name('dream.show_redirector');
Route::get('/comments/{id}', 'DreamCommentController@dreamComments')->name('comments');

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

// Orders
Route::group(['prefix' => 'order'], function(){
  Route::post('/', 'OrderController@store')->name('order.store');
  Route::get('/{email}/{code}', 'OrderController@orderComplete')->name('order.complete');
});

// Admin Middleware
Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
  Route::get('/', 'DashboardController@index')->name('dashboard.index');
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

  Route::group(['prefix' => 'orders'], function(){
    Route::get('/', 'OrderController@index')->name('orders.index');
    Route::get('/{order_no}', 'OrderController@show')->name('orders.show');
    Route::put('/{order_no}', 'OrderController@update')->name('orders.update');
  });
});

Route::get('/test/email/layout', function(){
    $product = App\Models\Product::find(1);
    $order = App\Models\Order::find(1);

    return view('mails.orders.delivery_to_customer')->with([
      'product' => $product,
      'order' => $order
    ]);
});

Route::get('/clear/db', function(){
    DB::table('jobs')->truncate();
    DB::table('notifications')->truncate();
    DB::table('dream_comments')->truncate();
    return redirect('/berjuta-mimpi-indonesia');
})->name('clear.db');

Route::get('/test/data', function(){

})->name('test.data');
