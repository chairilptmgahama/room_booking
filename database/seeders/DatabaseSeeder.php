<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        $users = array(
            array(
                'name' => 'My User',
                'username' => 'myuser',
                'password' => bcrypt('user_2024'),
                'is_active' => 1,
                'user_type' => 10,
            ),
        );
        foreach($users as $row){
            DB::table('users')->insert($row);
        }
        dd('done');
    }
}
