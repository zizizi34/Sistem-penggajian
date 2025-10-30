@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold">Absensi Anda</h2>

                <form method="POST" action="{{ route('absensi.store') }}" class="mt-4 flex items-center gap-3">
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
        </div>
    </div>
@endsection
