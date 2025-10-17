<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left: Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-100" />
                    <span class="ms-3 text-lg font-semibold text-gray-800 dark:text-gray-100">Sistem Penggajian</span>
                </a>
            </div>

            <!-- Center: Primary Nav -->
            <div class="hidden lg:flex lg:items-center lg:space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-nav-link>

                @if(Route::has('pegawai.index'))
                    <x-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">{{ __('Pegawai') }}</x-nav-link>
                @endif

                @if(Route::has('departemen.index'))
                    <x-nav-link :href="route('departemen.index')" :active="request()->routeIs('departemen.*')">{{ __('Departemen') }}</x-nav-link>
                @endif

                @if(Route::has('penggajian.index'))
                    <x-nav-link :href="route('penggajian.index')" :active="request()->routeIs('penggajian.*')">{{ __('Penggajian') }}</x-nav-link>
                @endif

                @if(Route::has('users.index'))
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">{{ __('Users') }}</x-nav-link>
                @endif
            </div>

            <!-- Right: Utilities -->
            <div class="flex items-center space-x-4">
                <!-- Search (desktop) -->
                <div class="hidden md:block">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative text-gray-600 dark:text-gray-300">
                        <input id="search" name="search" type="search" placeholder="Cari..." class="block w-56 pl-10 pr-3 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <button class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" title="Notifications">
                    <svg class="h-6 w-6 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
                                <span class="sr-only">Open user menu</span>
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-600 text-white">{{ strtoupper(substr(Auth::user()->name,0,1) ?? 'A') }}</span>
                                <span class="ms-2 hidden md:inline text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                                <svg class="ms-1 h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.67l3.71-3.48a.75.75 0 111.04 1.08l-4.25 4a.75.75 0 01-1.04 0l-4.25-4a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
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

                <!-- Mobile hamburger -->
                <div class="-me-2 flex items-center lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-gray-100 dark:border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>

            @if(Route::has('pegawai.index'))
                <x-responsive-nav-link :href="route('pegawai.index')">{{ __('Pegawai') }}</x-responsive-nav-link>
            @endif

            @if(Route::has('departemen.index'))
                <x-responsive-nav-link :href="route('departemen.index')">{{ __('Departemen') }}</x-responsive-nav-link>
            @endif

            @if(Route::has('penggajian.index'))
                <x-responsive-nav-link :href="route('penggajian.index')">{{ __('Penggajian') }}</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
