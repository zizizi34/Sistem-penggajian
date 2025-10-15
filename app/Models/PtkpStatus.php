<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtkpStatus extends Model
{
    use HasFactory;

    protected $table = 'ptkp_status';

    protected $fillable = [
        'kode_status',
        'keterangan',     
        'jumlah_ptkp',
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'id_ptkp_status');
    }
}
