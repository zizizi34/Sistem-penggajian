@extends('layouts.dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">Super Admin Dashboard</h2>
        <div class="text-sm text-gray-600">Halo, <span class="font-medium">{{ auth()->user()->name ?? 'Admin' }}</span></div>
    </div>
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg p-6 min-h-24 flex items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-md bg-blue-50 text-blue-700">
                            <!-- icon -->
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7M8 21h8M12 7v14"></path></svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalUsers ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6 min-h-24 flex items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-md bg-green-50 text-green-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"></path></svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pegawai</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalPegawai ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6 min-h-24 flex items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-md bg-yellow-50 text-yellow-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.567 3-3.5S13.657 1 12 1 9 2.567 9 4.5 10.343 8 12 8zM6 22v-6a4 4 0 014-4h4a4 4 0 014 4v6"></path></svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Departemen</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalDepartments ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg p-6 min-h-24 flex items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-md bg-red-50 text-red-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M5 18h14"></path></svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Penggajian</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalPenggajian ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Aktivitas Terbaru</h3>
                    <p class="mt-1 text-sm text-gray-500">Kegiatan terbaru dari pengguna, pegawai, dan proses penggajian.</p>

                    <div class="mt-6">
                        <div class="flow-root">
                            <ul class="divide-y divide-gray-200 max-h-80 overflow-y-auto">
                                @forelse($activities as $act)
                                    <li class="py-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-700">{{ strtoupper(substr($act['actor'] ?? 'S',0,1)) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ $act['actor'] }}</p>
                                                <p class="text-sm text-gray-500">{{ $act['action'] }} @if(!empty($act['note'])) — <span class="font-medium">{{ $act['note'] }}</span>@endif</p>
                                                <p class="mt-1 text-xs text-gray-400">{{ optional($act['time'])->format('Y-m-d H:i') ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-4 text-sm text-gray-500">Belum ada aktivitas.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Departemen</h3>
                    <p class="mt-1 text-sm text-gray-500">Daftar departemen dan jumlah pegawai per departemen.</p>

                    <div class="mt-4 space-y-3">
                        @forelse($departments as $d)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $d->nama_departemen }}</div>
                                    <div class="text-xs text-gray-500">{{ $d->pegawais_count ?? 0 }} pegawai</div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ Route::has('pegawai.index') ? route('pegawai.index', ['dept' => $d->id]) : '#' }}" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Lihat</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500">Belum ada departemen terdaftar.</div>
                        @endforelse
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-3">
                        <a href="{{ route('super.admins.create') }}" class="block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">Tambah Admin</a>
                        <a href="{{ Route::has('departemen.index') ? route('departemen.index') : '#' }}" class="block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Kelola Departemen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
