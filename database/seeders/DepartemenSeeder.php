<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departemens')->insert([
            ['nama_departemen' => 'IT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_departemen' => 'HRD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_departemen' => 'Keuangan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
