<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PtkpStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ptkp_status')->insert([
            ['nama_status' => 'TK/0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_status' => 'K/0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_status' => 'K/1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
