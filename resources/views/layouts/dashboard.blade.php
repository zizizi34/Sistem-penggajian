@props([])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Penggajian') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

<div class="min-h-screen flex">
    <!-- Left nav -->
    <aside class="w-72 md:w-64 bg-white border-r hidden md:flex flex-col min-h-screen">
        <div class="px-6 py-6 border-b">
            <a href="/" class="flex items-center space-x-3">
                <div class="h-8 w-8 bg-indigo-600 rounded flex items-center justify-center text-white font-bold">SP</div>
                <div class="text-lg font-semibold">{{ config('app.name', 'Sistem Penggajian') }}</div>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-justify">
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
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-xl">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</div>
                                    <div>
                                        <div class="font-medium">{{ auth()->user()->name ?? 'User' }}</div>
                                        <div class="text-sm text-gray-500">{{ auth()->user()->email ?? '' }}</div>
                                    </div>
                                </div>

                                <div>
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none transition">
                                                <svg class="h-4 w-4 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.67l3.71-3.48a.75.75 0 111.04 1.08l-4.25 4a.75.75 0 01-1.04 0l-4.25-4a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                                </svg>
                                                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>

                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
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
