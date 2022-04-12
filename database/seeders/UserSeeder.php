<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'nip' => '123456',
            'password' => Hash::make('123456'),
            'role'=> 'USER'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'nip' => '123',
            'password' => Hash::make('123456'),
            'role'=> 'ADMIN'
        ]);
    }
}
