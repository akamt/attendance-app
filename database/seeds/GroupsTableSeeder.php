<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'コンサル', 'IT事業部'
        ];

        foreach ($groups as $group) {
            DB::table('groups')->insert([
                'name' => $group,
            ]);
        }
    }
}
