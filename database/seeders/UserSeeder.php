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
            'division_id'=> '2',
            'password' => Hash::make('123456'),
            'role'=> 'USER'
        ]);

        DB::table('users')->insert([
            'name' => 'Bobby',
            'nip' => '12',
            'division_id'=> '3',
            'password' => Hash::make('123456'),
            'role'=> 'USER'
        ]);

        DB::table('users')->insert([
            'name' => 'Salemba',
            'nip' => '123',
            'division_id'=> '1',
            'password' => Hash::make('123456'),
            'role'=> 'ADMIN'
        ]);
    }
}
