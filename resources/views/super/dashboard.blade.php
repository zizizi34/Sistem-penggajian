@extends('layouts.dashboard')

@section('header')
    <div class="flex items-center justify-between text-justify">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Super Admin</h2>
        <div class="text-sm text-gray-600">Halo, <span class="font-medium">{{ auth()->user()->name ?? 'Admin' }}</span></div>
    </div>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Users Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5 border-l-4 border-blue-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Users</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                        <p class="mt-2 text-xs text-gray-600">Semua pengguna sistem (admin & user)</p>
                    </div>
                    <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded-lg bg-blue-50 text-blue-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6h4a6 6 0 016 6v1"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pegawai Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5 border-l-4 border-green-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pegawai</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPegawai ?? 0 }}</p>
                        <p class="mt-2 text-xs text-gray-600">Karyawan terdaftar dalam sistem</p>
                    </div>
                    <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded-lg bg-green-50 text-green-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Departemen Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5 border-l-4 border-yellow-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Departemen</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalDepartments ?? 0 }}</p>
                        <p class="mt-2 text-xs text-gray-600">Divisi/Bagian organisasi</p>
                    </div>
                    <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded-lg bg-yellow-50 text-yellow-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Penggajian Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5 border-l-4 border-red-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Penggajian</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPenggajian ?? 0 }}</p>
                        <p class="mt-2 text-xs text-gray-600">Proses transaksi gaji</p>
                    </div>
                    <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded-lg bg-red-50 text-red-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5 border-l-4 border-purple-500">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Admin</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalAdmins ?? 0 }}</p>
                        <p class="mt-2 text-xs text-gray-600">Pengelola departemen</p>
                    </div>
                    <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded-lg bg-purple-50 text-purple-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daftar Admin Section -->
        <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Admin</h3>
                    <p class="mt-1 text-sm text-gray-600">Kelola dan lihat semua admin yang terdaftar di sistem.</p>
                </div>
            </div>

            <div class="space-y-2 max-h-80 overflow-y-auto">
                @forelse($admins as $admin)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="h-10 w-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                <div class="text-xs text-gray-500">{{ $admin->email }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-gray-700">{{ $admin->departemen->nama_departemen ?? '—' }}</div>
                            <div class="text-xs text-gray-500">Departemen</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                        <p class="text-sm">Belum ada admin terdaftar</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6 pt-4 border-t">
                <a href="{{ route('super.admins.create') }}" class="inline-flex items-center px-4 py-2 border border-purple-600 text-purple-600 font-medium rounded-lg hover:bg-purple-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Admin
                </a>
            </div>
        </div>

        <!-- Admin Departemen Section -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Admin per Departemen</h3>
                <p class="mt-1 text-sm text-gray-600">Distribusi admin di setiap departemen. Klik untuk melihat detail.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 max-h-96 overflow-y-auto">
                @forelse($departments as $dept)
                    <a href="{{ Route::has('pegawai.index') ? route('pegawai.index', ['dept' => $dept->id]) : '#' }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-white rounded-lg border border-yellow-200 hover:border-yellow-300 hover:shadow-md transition duration-200 cursor-pointer group">
                        <!-- Left: Icon & Name -->
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="h-12 w-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($dept->nama_departemen, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 group-hover:text-yellow-700 transition">{{ $dept->nama_departemen }}</div>
                                <div class="text-xs text-gray-500 mt-1">Klik untuk lihat detail</div>
                            </div>
                        </div>
                        
                        <!-- Right: Stats (Aligned) -->
                        <div class="flex items-center justify-end gap-8 ml-4 flex-shrink-0">
                            <div class="text-right">
                                <div class="text-xl font-bold text-purple-600">{{ $dept->admins_count ?? 0 }}</div>
                                <div class="text-xs text-purple-500 font-medium">admin</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-green-600">{{ $dept->pegawais_count ?? 0 }}</div>
                                <div class="text-xs text-green-500 font-medium">pegawai</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="text-sm font-medium">Belum ada departemen</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6 pt-4 border-t">
                <a href="{{ Route::has('departemen.index') ? route('departemen.index') : '#' }}" class="inline-flex items-center px-4 py-2 border border-green-600 text-green-600 font-medium rounded-lg hover:bg-green-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Kelola Departemen
                </a>
            </div>
        </div>
    </div>
@endsection
