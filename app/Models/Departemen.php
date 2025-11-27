<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';

    protected $fillable = [
        'nama_departemen',
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'id_departemen');
    }

    public function admins()
    {
        return $this->hasMany(User::class, 'id_departemen')->where('role', 'admin');
    }

}
