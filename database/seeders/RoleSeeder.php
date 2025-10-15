<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            ['nama_role' => 'Super Admin'],
            ['nama_role' => 'Admin'],
            ['nama_role' => 'Karyawan'],
        ]);
    }
}
