<?php

use Columbia\User;

use Illuminate\Http\Request;


// Route::group(['middleware' => '?'], function () {
	//Add Pivot
	Route::post('/users/{id}/add/voucher', 'API\UserController@add_voucher');

	Route::post('/vouchers/{id}/add/user', 'API\VoucherController@add_user');
	//

	//Restoring
	Route::post('/users/{id}/restoring', 'API\UserController@restoring');

	Route::post('/vouchers/{id}/restoring', 'API\VoucherController@restoring');

	Route::post('/destinations/{id}/restoring', 'API\DestinationController@restoring');
	//

	Route::resources([
	    'users' => 'API\UserController',
	    'destinations' => 'API\DestinationController',
	    'vouchers' => 'API\VoucherController',
	]);
// });
