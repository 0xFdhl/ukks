<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Owner</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Dashboard</h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-3">
                <x-stat-card label="Transaksi selesai hari ini" :value="number_format($transaksiHariIni)" color="sky">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Pendapatan hari ini" color="emerald" :value="'Rp '.number_format($pendapatanHariIni, 0, ',', '.')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Pendapatan bulan ini" color="violet" :value="'Rp '.number_format($pendapatanBulanIni, 0, ',', '.')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.518l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('owner.rekap') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    Buka Rekap Transaksi
                </a>
            </div>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-900">Transaksi Selesai Terbaru</h3>
                <div class="overflow-x-auto"><table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Plat nomor</th><th class="px-4 py-3">Waktu keluar</th><th class="px-4 py-3">Durasi</th><th class="px-4 py-3">Petugas</th><th class="px-4 py-3 text-right">Biaya</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transaksiTerbaru as $item)
                            <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 font-semibold">{{ $item->kendaraan?->plat_nomor ?? '—' }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_keluar?->format('d/m/Y H:i') ?? '—' }}</td><td class="px-4 py-3">{{ $item->durasi_jam }} jam</td><td class="px-4 py-3">{{ $item->user?->nama_lengkap ?? '—' }}</td><td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table></div>
            </section>
        </div>
    </div>
</x-app-layout>
