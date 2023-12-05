<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Ayssam',
            'last_name' => 'Hassen',
            'email' => 'ayssamhassen@gmail.com',
            'password' => bcrypt('12345678'),
            'user_type' => 'RH',
           
            
        ]);
    }
}
