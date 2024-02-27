<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bagians')->insert([
            'nama_bagian'=>'Lembaga Penjaminan Mutu',
            'kode'=>'LPM',
            'id'=>1
        ]);
    }
}
