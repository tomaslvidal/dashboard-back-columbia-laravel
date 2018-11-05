<?php
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/vouchers/download/{file_name}', function ($file_name){
		return Storage::download('vouchers/'.$file_name);
	});

	Route::get('/users/download/{file_name}', function ($file_name){
		return Storage::download('users/'.$file_name);
	});

	Route::get('/destinations/download/{file_name}', function ($file_name){
		return Storage::download('destinations/'.$file_name);
	});

	Route::get('/{vue_capture?}', function (){
		return view('vue');
	})->where('vue_capture', '[\/\w\.-]*')->name('home');
});