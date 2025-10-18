@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Jadwal: {{ $pegawai->nama_pegawai }}</h2>
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 bg-gray-200 rounded">Kembali</a>
                </div>

                <form method="POST" action="{{ route('jadwal.store', $pegawai->id_pegawai) }}" class="mt-4 grid grid-cols-4 gap-3">
                    @csrf
                    <div>
                        <label class="block text-sm">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required class="mt-1 block w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label class="block text-sm">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="mt-1 block w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label class="block text-sm">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="mt-1 block w-full border rounded px-2 py-1">
                    </div>
                    <div class="flex items-end">
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded">Tambah Jadwal</button>
                    </div>
                </form>

                <div class="mt-6">
                    <ul class="divide-y divide-gray-200">
                        @forelse($jadwals as $jadwal)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <div class="font-medium">{{ $jadwal->tanggal_mulai }} @if($jadwal->tanggal_selesai) - {{ $jadwal->tanggal_selesai }}@endif</div>
                                    <div class="text-sm text-gray-500">{{ $jadwal->jam_mulai ?? '-' }} - {{ $jadwal->jam_selesai ?? '-' }} | {{ $jadwal->keterangan }}</div>
                                </div>
                                <div>
                                    <form method="POST" action="{{ route('jadwal.destroy', ['id' => $pegawai->id_pegawai, 'jadwal' => $jadwal->id]) }}" onsubmit="return confirm('Hapus jadwal?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="py-3 text-sm text-gray-500">Belum ada jadwal.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
