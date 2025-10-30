<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Pegawai;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $absensis = Absensi::where('user_id', $user->id)->orderByDesc('waktu')->limit(50)->get();
        return view('user.absensi', compact('absensis'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'keterangan' => 'nullable|string',
        ]);

        $record = new Absensi();
        $record->user_id = $user->id;
        // attempt to find pegawai record by name if exists
        $pegawai = Pegawai::where('nama_pegawai', $user->name)->first();
        if ($pegawai) {
            $record->id_pegawai = $pegawai->id_pegawai;
        }
        $record->jenis = $data['jenis'];
        $record->keterangan = $data['keterangan'] ?? null;
        $record->waktu = now();
        $record->save();

        return back()->with('status', 'Absensi dicatat.');
    }
}
