<?php

use Columbia\User;

use Illuminate\Http\Request;

//Add Pivot
Route::post('/users/{id}/add/voucher', 'UserController@add_voucher');

Route::post('/vouchers/{id}/add/user', 'VoucherController@add_user');
//

//Restoring
Route::post('/users/{id}/restoring', 'UserController@restoring');

Route::post('/vouchers/{id}/restoring', 'VoucherController@restoring');

Route::post('/destinations/{id}/restoring', 'DestinationController@restoring');
//

Route::resources([
    'users' => 'UserController',
    'destinations' => 'DestinationController',
    'vouchers' => 'VoucherController',
]);