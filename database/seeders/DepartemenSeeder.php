<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departemen;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['nama_departemen' => 'IT'],
            ['nama_departemen' => 'Pemasaran'],
        ];

        foreach ($departments as $d) {
            Departemen::firstOrCreate([
                'nama_departemen' => $d['nama_departemen'],
            ], $d);
        }
    }
}
