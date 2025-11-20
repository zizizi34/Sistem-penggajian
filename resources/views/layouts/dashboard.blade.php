@props([])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

<div class="min-h-screen flex">
    <!-- Left nav -->
    <aside class="w-72 md:w-64 bg-white border-r hidden md:flex flex-col min-h-screen">
        <div class="px-6 py-6 border-b">
            <a href="/" class="flex items-center space-x-3">
                <div class="h-8 w-8 bg-indigo-600 rounded flex items-center justify-center text-white font-bold">SP</div>
                <div class="text-lg font-semibold">{{ config('app.name', 'Sistem') }}</div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <ul class="space-y-2">
                <li><a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100">Home</a></li>
                @can('viewAny', \App\Models\Pegawai::class)
                    <li><a href="{{ route('pegawai.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100">Pegawai</a></li>
                @endcan
                <li><a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100">Absensi</a></li>
                <li><a href="#" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-100">Settings</a></li>
            </ul>
        </nav>

        <div class="px-4 py-4 border-t">
            <a href="#" class="text-sm text-gray-500">Help & information</a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-9">
                    <!-- header area -->
                    <div class="mb-6">
                        @hasSection('header')
                            <div class="bg-white p-6 rounded-lg shadow-sm">@yield('header')</div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        @yield('content')
                    </div>
                </div>

                <!-- Right panel -->
                <aside class="lg:col-span-3">
                    <div class="sticky top-6">
                        <div class="bg-white rounded-lg shadow p-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-xl">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</div>
                                <div>
                                    <div class="font-medium">{{ auth()->user()->name ?? 'User' }}</div>
                                    <div class="text-sm text-gray-500">{{ auth()->user()->email ?? '' }}</div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600">Lihat profil</a>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow p-4">
                            <h4 class="text-sm font-medium">Activity</h4>
                            <div class="mt-3 text-sm text-gray-500">Recent activity will appear here.</div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>
