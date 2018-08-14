<?php
use Faker\Generator as Faker;

$factory->define(Columbia\Voucher::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText($maxNbChars = 120, $indexSize = 1),
        'file_name' => $faker->text(10).$faker->fileExtension,
        'created_at' => $faker->dateTimeThisYear($max = '2018-07-01 00:00:00', $timezone = 'America/Argentina/Buenos_Aires'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'America/Argentina/Buenos_Aires')
    ];
});
