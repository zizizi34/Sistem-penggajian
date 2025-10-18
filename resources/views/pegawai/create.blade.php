@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold">Tambah Pegawai</h2>

                <form method="POST" action="{{ route('pegawai.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIK</label>
                        <input name="nik_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nik_pegawai') }}">
                        @error('nik_pegawai')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
                        <input name="nama_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nama_pegawai') }}">
                        @error('nama_pegawai')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('tanggal_masuk') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                            <input name="gaji_pokok" type="number" step="0.01" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('gaji_pokok') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Karyawan</label>
                            <select name="status_karyawan" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="tetap">Pegawai Tetap</option>
                                <option value="kontrak">Kontrak</option>
                                <option value="magang">Magang</option>
                            </select>
                        </div>
                    </div>

                    @if(auth()->user() && auth()->user()->role !== 'admin')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Departemen</label>
                            <select name="id_departemen" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="">Pilih departemen</option>
                                @foreach($departemen as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                        <a href="{{ route('pegawai.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
