@extends('layouts.dashboard')

@section('header')
    <h2 class="text-lg font-semibold">Absensi Anda</h2>
@endsection

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('absensi.store') }}" class="mt-2 flex items-center gap-3">
            @csrf
            <select name="jenis" class="border rounded px-3 py-2">
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
            <input name="keterangan" placeholder="Keterangan (opsional)" class="border rounded px-3 py-2">
            <button class="px-3 py-1 bg-indigo-600 text-white rounded">Catat</button>
        </form>

        <div class="mt-6">
            <h3 class="font-medium">Riwayat Terakhir</h3>
            <ul class="mt-3 divide-y divide-gray-200">
                @forelse($absensis as $a)
                    <li class="py-2 flex justify-between">
                        <div>
                            <div class="font-medium">{{ ucfirst($a->jenis) }} — {{ $a->waktu }}</div>
                            @if($a->keterangan)
                                <div class="text-sm text-gray-500">{{ $a->keterangan }}</div>
                            @endif
                        </div>
                        <div class="text-sm text-gray-400">ID: {{ $a->id }}</div>
                    </li>
                @empty
                    <li class="py-2 text-sm text-gray-500">Belum ada absensi.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
