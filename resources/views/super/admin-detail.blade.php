@extends('layouts.dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">Admin Departemen: {{ $departemen->nama_departemen }}</h2>
            <p class="text-sm text-gray-600 mt-1">Kelola admin di departemen ini</p>
        </div>
        <a href="{{ route('super.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">← Kembali ke Dashboard</a>
    </div>
@endsection

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Admin</h3>
            <p class="text-sm text-gray-600 mt-1">Total: {{ $admins->count() }} admin di departemen ini</p>
        </div>

        @if($admins->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <svg class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                <p class="text-sm font-medium">Belum ada admin di departemen ini</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($admins as $admin)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                        <!-- Admin Info -->
                        <div class="flex items-center gap-4 flex-1">
                            <div class="h-10 w-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $admin->name }}</div>
                                <div class="text-sm text-gray-600">{{ $admin->email }}</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <a href="{{ route('super.admin-detail.edit', $admin->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('super.admin-detail.destroy', $admin->id) }}" class="inline" onsubmit="return confirm('Yakin hapus admin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6 pt-4 border-t">
            <a href="{{ route('super.admins.create') }}" class="inline-flex items-center px-4 py-2 border border-purple-600 text-purple-600 font-medium rounded-lg hover:bg-purple-50 transition">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Admin
            </a>
        </div>
    </div>
@endsection
