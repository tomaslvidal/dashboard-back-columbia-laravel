<?php
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['verify' => true, 'register' => false]);

// Route::group(['middleware' => 'auth:api'], function () {
	Route::get('/vouchers_m/download/{file}', 'API\VoucherController@download');

	Route::get('/users_m/download/{file}', 'API\UserController@download');

	Route::get('/destinations_m/download/{file}', 'API\DestinationController@download');
// });

Route::group(['middleware' => ['auth', 'verified']], function () {
	Route::get('/vouchers/download/{file}', 'API\VoucherController@download');

	Route::get('/users/download/{file}', 'API\UserController@download');

	Route::get('/destinations/download/{file}', 'API\DestinationController@download');

	Route::get('/{vue_capture?}', 'HomeController@index')->where('vue_capture', '[\/\w\.-]*')->name('home');
});
