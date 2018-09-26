<?php

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
// Route::get('{path}', function () {
//     return view('home');
// })->where('path', '(.*)');

Route::get('/login', function () {
    return view('home');
})->name('login')->where('vue_capture', '[\/\w\.-]*');

// Route::group(['middleware' => 'auth:api'], function () {
	Route::get('/{vue_capture?}', function () { return view('home'); })->where('vue_capture', '[\/\w\.-]*');
// });
