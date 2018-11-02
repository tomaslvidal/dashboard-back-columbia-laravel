<?php

use Columbia\User;

use Illuminate\Http\Request;

Route::resource('destinations', 'API\DestinationController')->only([
    'index', 'show'
]);

Route::group(['middleware' => 'auth:api'], function () {
	//Add Pivot
	Route::post('/users/{id}/add/voucher', 'API\UserController@add_voucher');

	Route::post('/vouchers/{id}/add/user', 'API\VoucherController@add_user');
	//

	//Restoring
	Route::post('/users/{id}/restoring', 'API\UserController@restoring');

	Route::post('/vouchers/{id}/restoring', 'API\VoucherController@restoring');

	Route::post('/destinations/{id}/restoring', 'API\DestinationController@restoring');
	//

	//Delete file
	Route::post('/vouchers/{id}/delete', 'API\VoucherController@delete_file');

	Route::post('/destinations/{id}/delete', 'API\DestinationController@delete_file');
	//

	Route::resource('destinations', 'API\DestinationController')->except(['index', 'show']);

	Route::resource('surveys/fields', 'API\SurveyFieldController');

	Route::resource('surveys/options', 'API\SurveyOptionController');

	Route::resources([
	    'users' => 'API\UserController',
	    'vouchers' => 'API\VoucherController',
	    'surveys' => 'API\SurveyController',
	]);
});