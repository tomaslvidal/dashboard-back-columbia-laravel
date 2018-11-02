<?php
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/vouchers/download/{file_name}', function ($file_name){
	return Storage::download('vouchers/'.$file_name);
});

Route::get('/users/download/{file_name}', function ($file_name){
	return Storage::download('users/'.$file_name);
});

Route::get('/destinations/download/{file_name}', function ($file_name){
	return Storage::download('destinations/'.$file_name);
});

Route::get('/{vue_capture?}', function () { return view('home'); })->where('vue_capture', '[\/\w\.-]*')->name('login');

Route::get('/validate-token', function () {
	return ['data' => 'Token is valid'];
})->middleware('auth:api');