<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'name' => 'Kertas',
            'unit_id' => '1',
            'type_id'=> '1',
            'quantity' => 0,
        ]);

        DB::table('product')->insert([
            'name' => 'Pulpen',
            'unit_id' => '2',
            'type_id'=> '1',
            'quantity' => 0,
        ]);
    }
}
