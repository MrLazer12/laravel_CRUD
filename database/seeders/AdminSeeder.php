<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert admin accaunt
        DB::table('administrators')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        // Insert simple user accaunt
        DB::table('administrators')->insert([
            'username' => 'user1',
            'password' => Hash::make('user1'),
            'role' => 'user',
        ]);
    }
}
