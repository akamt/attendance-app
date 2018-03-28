<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        テスト用
//        $users = factory(App\User::class, 40)->create();
//
//        $users->each(function ($users) {
//            factory('App\Expense', 10)->create(['user_id' => $users->id]);
//        });

        $users = [
            ['name' => 'suwa', 'role' => 1, 'group' => 1],
            ['name' => 'hfujihara', 'role' => 2, 'group' => 1],
            ['name' => 'suzuki', 'role' => 2, 'group' => 1],
            ['name' => 'wfukui', 'role' => 2, 'group' => 1],
            ['name' => 'aoki', 'role' => 3, 'group' => 1],
            ['name' => 'takahashi', 'role' => 4, 'group' => 1],
            ['name' => 'matsuda', 'role' => 4, 'group' => 1],
            ['name' => 'yhattori', 'role' => 4, 'group' => 1],
            ['name' => 'ysuzuki', 'role' => 2, 'group' => 2],
            ['name' => 'kaga', 'role' => 4, 'group' => 2],
            ['name' => 'yishizaki', 'role' => 4, 'group' => 2],
            ['name' => 'thirabayashi', 'role' => 4, 'group' => 2],
            ['name' => 'yaoka', 'role' => 4, 'group' => 2],
            ['name' => 'kaneko', 'role' => 4, 'group' => 2],
            ['name' => 'admin', 'role' => 1, 'group' => 1],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['name'] . '@nlinks.co.jp',
                'password' => bcrypt($user['name']),
                'role_id' => $user['role'],
                'group_id' => $user['group'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
