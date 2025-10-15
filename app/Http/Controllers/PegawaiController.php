<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with(['jabatan', 'departemen', 'ptkpStatus'])->get();
        return view('pegawai.index', compact('pegawais'));
    }
}
