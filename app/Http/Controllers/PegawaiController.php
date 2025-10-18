<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Departemen;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $dept = request()->query('dept');

        // If the authenticated user is an admin, force department to their assigned one.
        if ($user && $user->role === 'admin') {
            $dept = $user->id_departemen;
        }

        $query = Pegawai::with(['jabatan', 'departemen', 'ptkpStatus']);
        if ($dept) {
            $query->where('id_departemen', $dept);
        }

        $pegawais = $query->get();

        $departemen = Departemen::orderBy('nama_departemen')->get();
        $selectedDept = $dept ? Departemen::find($dept) : null;

        return view('pegawai.index', compact('pegawais', 'departemen', 'selectedDept'));
    }

    public function create()
    {
        $departemen = Departemen::orderBy('nama_departemen')->get();
        return view('pegawai.create', compact('departemen'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik_pegawai' => 'required|string|unique:pegawais,nik_pegawai',
            'nama_pegawai' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'id_jabatan' => 'nullable|exists:jabatans,id',
            'tanggal_masuk' => 'nullable|date',
            // gaji_pokok must be numeric and at least 0; set a high upper bound to allow large salaries
            'gaji_pokok' => 'nullable|numeric|min:0|max:1000000000',
            'status_karyawan' => 'nullable|in:magang,kontrak,tetap',
        ]);

        // If user is admin, force id_departemen to the admin's department
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            $data['id_departemen'] = $user->id_departemen;
        } else {
            // fallback: allow department selection only for non-admins (or super)
            $data['id_departemen'] = $request->input('id_departemen');
        }

        // Ensure numeric gaji_pokok default
        if (empty($data['gaji_pokok'])) {
            $data['gaji_pokok'] = 0;
        }

        // Default status
        if (empty($data['status_karyawan'])) {
            $data['status_karyawan'] = 'tetap';
        }

        Pegawai::create($data);

        return redirect()->route('pegawai.index', ['dept' => $data['id_departemen'] ?? null])->with('status', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        // Authorization: admin can only edit within their department
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $jabatans = \App\Models\Jabatan::orderBy('nama_jabatan')->get();
        return view('pegawai.edit', compact('pegawai', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $data = $request->validate([
            'nama_pegawai' => 'required|string',
            'gaji_pokok' => 'nullable|numeric|min:0|max:1000000000',
            'status_karyawan' => 'nullable|in:magang,kontrak,tetap',
            'id_jabatan' => 'nullable|exists:jabatans,id',
        ]);

        $pegawai->update($data);

    return redirect()->route('admin.dashboard', ['dept' => $pegawai->id_departemen])->with('status', 'Data pegawai diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = auth()->user();
        if ($user->role === 'admin' && $user->id_departemen && $pegawai->id_departemen != $user->id_departemen) {
            abort(403);
        }

        $pegawai->delete();
        return redirect()->route('admin.dashboard')->with('status', 'Pegawai dihapus.');
    }
}
