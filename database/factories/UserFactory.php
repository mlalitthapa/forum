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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define("App\Models\Thread", function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory("App\User")->create()->id;
        },
        'channel_id' => function() {
            return factory("App\Models\Channel")->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->define("App\Models\Reply", function (Faker $faker) {
    return [
        'thread_id' => function() {
            return factory('App\Models\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory("App\User")->create()->id;
        },
        'body' => $faker->paragraph
    ];
});

$factory->define("App\Models\Channel", function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name
    ];
});
