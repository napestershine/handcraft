<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
    $statuses = ['pending', 'Confirmed', 'In Progress', 'Completed'];
    return [
        'user_id' => function () {
            return \App\Models\User::inRandomOrder()->first()->id;
        },
        'status' => $statuses[array_rand($statuses)],
        'pick_time' => $faker->dateTime,
        'source' => $faker->streetAddress,
        'destination' => $faker->streetAddress,
    ];
});
