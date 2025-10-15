<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'nik_pegawai', 'nama_pegawai', 'jenis_kelamin',
        'tanggal_lahir', 'alamat', 'no_hp', 'bank_pegawai',
        'no_rekening', 'npwp', 'id_ptkp_status',
        'id_jabatan', 'id_departemen', 'tanggal_masuk', 'gaji_pokok'
    ];

    // 🔹 Relasi ke jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    // 🔹 Relasi ke departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }

    // 🔹 Relasi ke ptkp_status
    public function ptkpStatus()
    {
        return $this->belongsTo(PtkpStatus::class, 'id_ptkp_status');
    }
}
