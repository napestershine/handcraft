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

$factory->define(\App\Models\City::class, function (Faker $faker) {
    $city = $faker->city;
    return [
        'name' => $city,
        'zip' => $faker->randomNumber(5),
        'slug' => str_replace(' ', '-', strtolower($city))
    ];
});

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    $category = $faker->name;
    return [
        'name' => $category,
        'uid' => $faker->randomNumber(6),
        'slug' => str_replace(' ', '-', strtolower($category)),
        'image' => $faker->imageUrl(200, 200)
    ];
});

$factory->define(\App\Models\Job::class, function (Faker $faker) {
    $statuses = ['Pending', 'Confirmed', 'In Progress', 'Completed'];
    return [
        'title' => $faker->sentence(2),
        'description' => $faker->paragraph(2),
        'execution' => $faker->dayOfWeek(),
        'status' => $statuses[array_rand($statuses)],
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'city_id' => function () {
            return factory(\App\Models\City::class)->create()->id;
        },
        'category_id' => function () {
            return factory(\App\Models\Category::class)->create()->id;
        },
    ];
});

