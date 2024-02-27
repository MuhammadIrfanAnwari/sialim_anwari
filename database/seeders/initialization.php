<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class initialization extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin'),
            'level'=>'super_admin',
            'is_super'=>1,
            'id_bagian'=>1
        ]);
    }
}
