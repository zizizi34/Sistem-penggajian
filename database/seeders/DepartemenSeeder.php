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
            ['nama_departemen' => 'Direktur'],
            ['nama_departemen' => 'Administrasi'],
            ['nama_departemen' => 'Keuangan'],
            ['nama_departemen' => 'IT'],
            ['nama_departemen' => 'Pemasaran'],
            ['nama_departemen' => 'Penjualan'],
            ['nama_departemen' => 'Operasional'],
            ['nama_departemen' => 'SDM (Sumber Daya Manusia)'],
            ['nama_departemen' => 'Produksi'],
            ['nama_departemen' => 'Quality Control'],
        ];

        foreach ($departments as $d) {
            Departemen::firstOrCreate([
                'nama_departemen' => $d['nama_departemen'],
            ], $d);
        }
    }
}
