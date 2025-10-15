<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
  use HasFactory;

  protected $fillable = [
      'nama_jabatan',
      'tunjangan_jabatan',
  ];

  public function pegawais()
  {
      return $this->hasMany(Pegawai::class, 'id_jabatan');
  }
}
