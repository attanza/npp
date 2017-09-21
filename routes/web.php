<?php

// Auth::routes();
// Main Menu
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rumah-negeri-para-pemimpi', 'HomeController@index')->name('home');
Route::get('/berjuta-mimpi-indonesia', 'BmiController@index')->name('bmi.index');
Route::get('/tentang-negeri-para-pemimpi', 'AboutController@index')->name('about.index');
Route::get('/kontak-negeri-para-pemimpi', 'ContactController@index')->name('contact.index');
Route::post('/kontak-negeri-para-pemimpi', 'ContactController@store')->name('contact.store');
Route::get('/syarat-ketentuan', function(){
  return view('terms');
})->name('terms');

// Auths
Route::get('/login', 'HomeController@index')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

// Dream without middleware
Route::post('/dream/listing', 'DreamController@dreamList')->name('dream.listing');
Route::get('/dream/count', 'DreamController@dreamCount')->name('dream.count');

Route::get('/dream/{slug}', 'DreamController@dreamShow')->name('dream.show');
Route::get('/dream/{slug}/{id}', 'DreamController@dreamRedirector')->name('dream.show_redirector');
Route::get('/comments/{id}', 'DreamCommentController@dreamComments')->name('comments');

// Boost
Route::get('/boost/{id}', 'BoostController@getBoosts')->name('boost.get_boosts');
Route::post('/boost/{id}/listing', 'BoostController@listing')->name('boost.listing');

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
    // Notifications
    Route::get('notifikasi', 'NotificationController@index')->name('notification.index');
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
  Route::group(['prefix' => 'products'], function(){
    Route::get('/', 'ProductController@index')->name('products.index');
  });
});

// Dream Comments
Route::group(['prefix' => 'dream-comments'], function(){
  Route::get('/parent-comments/{dreamId}', 'ParentCommentController@getParentComments')->name('comments.parent');
  Route::get('/child-comments/{parentId}', 'ChildCommentController@getChildComments')->name('comments.child');
});

// Dream Search
Route::post('/dream-search', 'DreamSearchController@search');

Route::get('/clear-cache', function(){
    Artisan::call('cache:clear');
    return redirect('/');
});
