@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold">Edit Pegawai</h2>

                <form method="POST" action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm">Nama</label>
                        <input name="nama_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm">Gaji Pokok</label>
                            <input name="gaji_pokok" type="number" step="0.01" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}">
                        </div>
                        <div>
                            <label class="block text-sm">Status</label>
                            <select name="status_karyawan" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="tetap" {{ $pegawai->status_karyawan === 'tetap' ? 'selected' : '' }}>Pegawai Tetap</option>
                                <option value="kontrak" {{ $pegawai->status_karyawan === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                                <option value="magang" {{ $pegawai->status_karyawan === 'magang' ? 'selected' : '' }}>Magang</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm">Jabatan</label>
                        <select name="id_jabatan" class="mt-1 block w-full border rounded px-3 py-2">
                            <option value="">Tidak ada</option>
                            @foreach($jabatans as $jab)
                                <option value="{{ $jab->id }}" {{ $pegawai->id_jabatan == $jab->id ? 'selected' : '' }}>{{ $jab->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                        <form method="POST" action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}" onsubmit="return confirm('Hapus pegawai ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                        </form>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 rounded">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
