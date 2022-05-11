<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name' => 'Rim',
        ]);

        DB::table('units')->insert([
            'name' => 'Dus',
        ]);

        DB::table('units')->insert([
            'name' => 'Buah',
        ]);

        DB::table('units')->insert([
            'name' => 'Lusin',
        ]);

        DB::table('units')->insert([
            'name' => 'Box',
        ]);

        DB::table('units')->insert([
            'name' => 'Meter',
        ]);

        DB::table('units')->insert([
            'name' => 'Centimeter',
        ]);

        DB::table('units')->insert([
            'name' => 'Kilogram',
        ]);

        DB::table('units')->insert([
            'name' => 'Gram',
        ]);
    }
}
