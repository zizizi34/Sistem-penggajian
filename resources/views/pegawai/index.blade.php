@extends('layouts.dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Daftar Pegawai</h1>
            @if($selectedDept)
                <p class="text-sm text-gray-500">Departemen: <span class="font-medium">{{ $selectedDept->nama_departemen }}</span></p>
            @endif
        </div>
        <div>
            <form method="get" action="{{ route('pegawai.index') }}">
                <select name="dept" onchange="this.form.submit()" class="border rounded px-3 py-2 text-sm">
                    <option value="">Semua Departemen</option>
                    @foreach($departemen as $dep)
                        <option value="{{ $dep->id }}" {{ optional($selectedDept)->id == $dep->id ? 'selected' : '' }}>{{ $dep->nama_departemen }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mt-2 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pegawais as $pegawai)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->nama_pegawai }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->departemen->nama_departemen ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->tanggal_masuk }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4" colspan="5">Belum ada pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
