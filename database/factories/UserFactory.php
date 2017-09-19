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

$factory->define(Forum\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define("Forum\Models\Thread", function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory("Forum\User")->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->define("Forum\Models\Reply", function (Faker $faker) {
    return [
        'thread_id' => function() {
            return factory('Forum\Models\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory("Forum\User")->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
