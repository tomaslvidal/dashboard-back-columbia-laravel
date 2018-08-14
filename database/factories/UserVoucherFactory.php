<?php
use Carbon\Carbon;

$factory->define(Columbia\UserVoucher::class, function (Faker\Generator $faker){
	$atributtes = array(
		'state' => false,
		'user_id' => "",
		'voucher_id' => ""
	);

	while($atributtes['state']==false){
		$random_user_id = Columbia\User::select('id')->orderByRaw("RAND()")->first()->id;

		$random_voucher_id = Columbia\Voucher::select('id')->orderByRaw("RAND()")->first()->id;

		$user_voucher = Columbia\UserVoucher::where('user_id', $random_user_id)->where('voucher_id', $random_voucher_id)->get();

		if($user_voucher->count()==0){
			$atributtes['user_id'] = $random_user_id;

			$atributtes['voucher_id'] = $random_voucher_id;

			$atributtes['state'] = true;
		}
	}

	return [
		'user_id' => $atributtes['user_id'],
		'voucher_id' => $atributtes['voucher_id'],
		'created_at' => Carbon::now()
	];
});

