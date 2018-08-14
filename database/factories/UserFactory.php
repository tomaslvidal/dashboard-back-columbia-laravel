<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Columbia\User::class, function (Faker $faker) {
    return [
        'password' => $faker->password, // secret
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->freeEmail,
        'telephone' => $faker->e164PhoneNumber,
        'created_at' => $faker->dateTimeThisYear($max = '2018-07-01 00:00:00', $timezone = 'America/Argentina/Buenos_Aires'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'America/Argentina/Buenos_Aires'),
        'remember_token' => str_random(10),
    ];
});
