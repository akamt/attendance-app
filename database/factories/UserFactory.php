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
    $roles = [1, 2, 3, 4];
    $groups = [1, 2];
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'role_id' => $faker->randomElement($roles),
        'group_id' => $faker->randomElement($groups),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Expense::class, function (Faker $faker) {
    $array = ['定期代', '書籍代', '営業接待', 'タクシー代', '宿泊費'];
    $date = $faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now');
    return [
        'name' => $faker->randomElement($array),
        'category_id' => $faker->randomDigitNotNull,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'payment' => $faker->company,
        'use_day' => $date->format('Y-m-d'),
        'month' => $date->format('Y-m'),
        'value' => $faker->randomNumber(4),
    ];
});
