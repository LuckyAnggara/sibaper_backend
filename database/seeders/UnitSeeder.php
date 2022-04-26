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
            'name' => 'rim',
        ]);

        DB::table('units')->insert([
            'name' => 'dus',
        ]);

        DB::table('units')->insert([
            'name' => 'pieces',
        ]);

        DB::table('units')->insert([
            'name' => 'buah',
        ]);
    }
}
