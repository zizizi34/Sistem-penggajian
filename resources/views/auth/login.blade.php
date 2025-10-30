@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: Branding / message -->
            <div class="hidden md:flex flex-col justify-center bg-white rounded-lg shadow p-8">
                <div class="text-indigo-600 font-bold text-2xl">Sistem Penggajian</div>
                <p class="mt-4 text-gray-600">Platform manajemen karyawan & penggajian yang aman dan mudah digunakan. Masuk untuk mengelola absensi, jadwal, dan penggajian.</p>
                <div class="mt-6">
                    <img src="/build/assets/office-illustration.svg" alt="office illustration" class="w-full h-48 object-contain opacity-90" />
                </div>
            </div>

            <!-- Right: login card -->
            <div class="bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-semibold text-gray-800">Masuk ke akun Anda</h2>
                <p class="mt-2 text-sm text-gray-500">Gunakan email atau nama pengguna Anda.</p>

                <x-auth-session-status class="mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4" novalidate>
                    @csrf

                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700">Email atau Nama</label>
                        <input id="login" name="login" value="{{ old('login') }}" required autofocus
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" />
                        @error('login')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 pr-10" />
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-gray-500" aria-label="Tampilkan kata sandi">
                                <!-- Eye open (Heroicons: eye) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 10C3.732 6.943 6.522 5 10 5s6.268 1.943 7.542 5c-1.274 3.057-4.064 5-7.542 5S3.732 13.057 2.458 10z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 13a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                                <!-- Eye closed (Heroicons: eye-off) - hidden by default -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 9.88A3 3 0 0114.12 14.12" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.21 6.21A9.01 9.01 0 0112 4c4.478 0 8.268 1.943 9.542 5-.37.887-.92 1.708-1.63 2.405" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.12 9.88L20.82 3.18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-sm">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            <span class="ml-2 text-gray-600">Ingat saya</span>
                        </label>

                        <div class="text-sm">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Lupa kata sandi?</a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">Masuk</button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">Belum punya akun? Hubungi admin untuk membuat akun.</p>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const btn = document.getElementById('togglePassword');
            const pw = document.getElementById('password');
            if (!btn || !pw) return;
            btn.addEventListener('click', function(){
                const open = btn.querySelector('.eye-open');
                const closed = btn.querySelector('.eye-closed');
                if (pw.type === 'password') {
                    pw.type = 'text';
                    if (open) open.classList.add('hidden');
                    if (closed) closed.classList.remove('hidden');
                } else {
                    pw.type = 'password';
                    if (open) open.classList.remove('hidden');
                    if (closed) closed.classList.add('hidden');
                }
            });
        })();
    </script>
@endsection
