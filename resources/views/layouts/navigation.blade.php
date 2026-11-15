<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-gray-200 bg-white/90 backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $menus = [
                            'admin' => [
                                ['admin.dashboard', 'admin.dashboard', 'Dashboard'],
                                ['admin.user.index', 'admin.user.*', 'User'],
                                ['admin.tarif.index', 'admin.tarif.*', 'Tarif'],
                                ['admin.area.index', 'admin.area.*', 'Area'],
                                ['admin.kendaraan.index', 'admin.kendaraan.*', 'Kendaraan'],
                                ['admin.log.index', 'admin.log.*', 'Log'],
                            ],
                            'petugas' => [
                                ['petugas.dashboard', 'petugas.dashboard', 'Dashboard'],
                                ['petugas.transaksi.index', 'petugas.transaksi.*||petugas.struk', 'Transaksi'],
                            ],
                            'owner' => [
                                ['owner.dashboard', 'owner.dashboard', 'Dashboard'],
                                ['owner.rekap', 'owner.rekap', 'Rekap Transaksi'],
                            ],
                        ];
                        $role = Auth::user()->role;
                    @endphp

                    @foreach (($menus[$role] ?? []) as $item)
                        @php [$route, $pattern, $label] = $item; $isActive = collect(explode('||', $pattern))->contains(fn ($p) => request()->routeIs($p)); @endphp
                        <x-nav-link :href="route($route)" :active="$isActive">{{ $label }}</x-nav-link>
                    @endforeach
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 rounded-full py-1.5 pe-3 ps-2 text-sm transition hover:bg-gray-100 focus:outline-none">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-sky-500 text-xs font-bold text-white">
                                {{ mb_strtoupper(mb_substr(Auth::user()->nama_lengkap, 0, 1)) }}
                            </span>
                            <span class="text-start leading-tight">
                                <span class="block font-semibold text-gray-800">{{ Auth::user()->nama_lengkap }}</span>
                                <span class="block text-xs font-medium uppercase tracking-wide text-blue-500">{{ Auth::user()->role }}</span>
                            </span>
                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @php $role = Auth::user()->role; @endphp
            @foreach (($menus[$role] ?? []) as $item)
                @php [$route, $pattern, $label] = $item; @endphp
                <x-responsive-nav-link :href="route($route)" :active="collect(explode('||', $pattern))->contains(fn ($p) => request()->routeIs($p))">{{ $label }}</x-responsive-nav-link>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center gap-3 px-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-sky-500 text-sm font-bold text-white">
                    {{ mb_strtoupper(mb_substr(Auth::user()->nama_lengkap, 0, 1)) }}
                </span>
                <div>
                    <div class="font-semibold text-base text-gray-800">{{ Auth::user()->nama_lengkap }}</div>
                    <div class="font-medium text-xs uppercase tracking-wide text-blue-500">{{ Auth::user()->role }} · {{ Auth::user()->username }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
