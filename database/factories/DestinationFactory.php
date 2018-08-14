<?php

use Faker\Generator as Faker;

$factory->define(Columbia\Destination::class, function (Faker $faker) {
    return [
        'title' => $faker->text(15),
        'subtitle' => $faker->text(10),
        'description' => $faker->sentence(10, true),
        'image1' => $faker->text(6).'jpg',
        'image2' => $faker->text(6).'jpg',
        'image3' => $faker->text(6).'jpg',
        'image4' => $faker->text(6).'jpg',
        'image5' => $faker->text(6).'jpg',
        'created_at' => $faker->dateTimeThisYear($max = '2018-07-01 00:00:00', $timezone = 'America/Argentina/Buenos_Aires'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'America/Argentina/Buenos_Aires')
    ];
});
