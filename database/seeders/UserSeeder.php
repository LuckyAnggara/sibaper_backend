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
            'name' => 'Lucky',
            'nip' => '123456',
            'bagian' => 'Keuangan',
            'password' => Hash::make('123456'),
            'role'=> 'USER'
        ]);

        DB::table('users')->insert([
            'name' => 'Salemba',
            'nip' => '123',
            'bagian' => 'null',
            'password' => Hash::make('123456'),
            'role'=> 'ADMIN'
        ]);
    }
}
