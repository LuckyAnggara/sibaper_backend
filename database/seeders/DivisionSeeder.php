<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([
            'name' => 'Subsi Keuangan dan Perlengkapan',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Subsi Umum',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Subsi Administrasi dan Perawatan',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Subsi Bimbingan Kegiatan',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Subsi BHP',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Tata Usaha',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Seksi Pengelolaan',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Seksi Pelayanan Tahanan',
        ]);

        DB::table('divisions')->insert([
            'name' => 'Kesatuan Pengamanan Rutan',
        ]);
    }
}
