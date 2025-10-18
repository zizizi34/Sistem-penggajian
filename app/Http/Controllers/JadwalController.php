<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Pegawai;

class JadwalController extends Controller
{
    public function index($pegawaiId)
    {
        $pegawai = Pegawai::findOrFail($pegawaiId);
        // admin dept check
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $jadwals = Jadwal::where('id_pegawai', $pegawaiId)->orderByDesc('tanggal_mulai')->get();

        // If request is AJAX (or explicit ?ajax=1), return the fragment HTML so the dashboard can load it into a modal
        if (request()->ajax() || request()->query('ajax') == '1') {
            return view('jadwal._fragment', compact('pegawai', 'jadwals'))->render();
        }

        return view('jadwal.index', compact('pegawai', 'jadwals'));
    }

    public function store(Request $request, $pegawaiId)
    {
        $pegawai = Pegawai::findOrFail($pegawaiId);
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $data = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'keterangan' => 'nullable|string',
        ]);

        $data['id_pegawai'] = $pegawaiId;
        Jadwal::create($data);
        return redirect()->route('jadwal.index', $pegawaiId)->with('status', 'Jadwal ditambahkan.');
    }

    public function destroy($pegawaiId, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $pegawai = Pegawai::findOrFail($pegawaiId);
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $jadwal->delete();
        return redirect()->route('jadwal.index', $pegawaiId)->with('status', 'Jadwal dihapus.');
    }
}
