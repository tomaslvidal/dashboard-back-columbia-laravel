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

// Route::get('/auth', function (){
// 	$FSDFSD = new Auth('session');

// 	Auth::loginUsingId(2, true);
// });

// Route::get('/asd', function (){
// 	return Storage::download('vouchers/'.'k26asCPH5Xof2Uu6xXlwa0WuaP0x5oHILCuEIbLL.jpeg');
// });

Route::get('/{vue_capture?}', function () { return view('home'); })->where('vue_capture', '[\/\w\.-]*')->name('login');

Route::get('/validate-token', function () {
	return ['data' => 'Token is valid'];
})->middleware('auth:api');
