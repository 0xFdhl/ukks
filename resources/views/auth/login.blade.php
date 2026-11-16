<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ParkirBCM') }} — Masuk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-2">
            <!-- Brand panel -->
            <aside class="relative hidden overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-sky-500 lg:flex lg:flex-col lg:justify-between p-12 text-white">
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-32 -left-16 h-96 w-96 rounded-full bg-sky-400/20 blur-3xl"></div>

                <div class="relative flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/30">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                            <path d="M6 20V4h6.5a4.75 4.75 0 0 1 0 9.5H9" stroke="white" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="text-xl font-extrabold tracking-tight">Parkir<span class="text-sky-200">IN</span></span>
                </div>

                <div class="relative max-w-md">
                    <h1 class="text-4xl font-extrabold leading-tight">Sistem Manajemen Parkir Modern</h1>
                    <p class="mt-4 text-blue-100 leading-relaxed">Kelola tarif, area, kendaraan, dan transaksi parkir dalam satu aplikasi — lengkap dengan struk digital dan rekap pendapatan.</p>

                    <ul class="mt-8 space-y-3 text-sm text-blue-100">
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-2.25-6.75a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25v6a2.25 2.25 0 002.25 2.25h6a2.25 2.25 0 002.25-2.25V11.25M16.5 18h4.5a1.5 1.5 0 001.5-1.5V7.5a1.5 1.5 0 00-1.5-1.5h-4.5a1.5 1.5 0 00-1.5 1.5v9a1.5 1.5 0 001.5 1.5z" /></svg>
                            </span> Transaksi masuk &amp; keluar dengan struk siap cetak
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                            </span> Rekap pendapatan untuk pemilik parkir
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            </span> Pantau kapasitas tiap area parkir real-time
                        </li>
                    </ul>
                </div>

                <p class="relative text-xs text-blue-200/80">{{ config('app.name', 'ParkirBCM') }} &copy; {{ date('Y') }}</p>
            </aside>

            <!-- Form panel -->
            <main class="flex flex-col justify-center items-center px-6 py-12 sm:px-12 bg-gray-50">
                <div class="w-full max-w-md">
                    <!-- Mobile brand -->
                    <div class="mb-8 flex justify-center lg:hidden">
                        <x-application-logo />
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900">Selamat datang kembali</h2>
                    <p class="mt-1 text-sm text-gray-500">Masuk menggunakan akun yang telah terdaftar.</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <x-alert type="success" class="mt-6">{{ session('status') }}</x-alert>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5 rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200/70">
                        @csrf

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" value="Username" />
                            <div class="relative mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <x-text-input id="username" class="block w-full pl-10" type="text" name="username" :value="old('username')" placeholder="cth: admin" required autofocus autocomplete="username" />
                            </div>
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <x-text-input id="password" class="block w-full pl-10"
                                              type="password"
                                              name="password"
                                              placeholder="••••••••"
                                              required autocomplete="current-password" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <x-primary-button class="w-full justify-center py-2.5 text-sm">
                            Masuk
                        </x-primary-button>
                    </form>

                    <p class="mt-6 text-center text-xs text-gray-400">Akun demo: admin · petugas · owner (password: password)</p>
                </div>
            </main>
        </div>
    </body>
</html>
