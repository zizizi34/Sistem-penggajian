<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawais')->insert([
            [
                'nama_pegawai' => 'Naren',
                'nik_pegawai' => '123456',
                'jenis_kelamin' => 'L',
                'alamat' => 'Surakarta',
                'no_hp' => '08123456789',
                'npwp' => '09.123.456.7-890.000',
                'bank_pegawai' => 'BCA',
                'no_rekening' => '1234567890',
                'gaji_pokok' => 5000000,
                'tanggal_lahir' => '2005-10-10',
                'tanggal_masuk' => '2024-01-01',
                'id_ptkp_status' => 1,
                'id_jabatan' => 1,
                'id_departemen' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
