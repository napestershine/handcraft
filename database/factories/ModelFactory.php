<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10)
    ];
});

$factory->define(\App\Models\Job::class, function (Faker $faker) {
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