<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 40)->create();

        $users->each(function ($users) {
            factory('App\Expense', 10)->create(['user_id' => $users->id]);
        });
    }
}
