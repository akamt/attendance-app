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
    $array = [1, 2];
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'role_id' => $faker->randomElement($array),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Expense::class, function (Faker $faker) {
    $array = ['定期代', '書籍代', '営業接待', 'タクシー代', '宿泊費'];
    return [
        'name' => $faker->randomElement($array),
        'category_id' => $faker->randomDigitNotNull,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'payment' => $faker->company,
        'month' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')->format('Y-m'),
        'value' => $faker->randomNumber(4),
    ];
});
