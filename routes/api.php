<?php

use Columbia\User;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/user', function (User $user) {
//     return $user::all();
// });

Route::post('/users/add/voucher/{id}', 'UserController@add_voucher');

Route::resource('/users', 'UserController');