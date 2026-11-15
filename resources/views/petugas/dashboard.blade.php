<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Petugas</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Dashboard</h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-3">
                <x-stat-card label="Sedang parkir" :value="number_format($transaksiAktif)" color="amber">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Transaksi masuk hari ini" :value="number_format($transaksiHariIni)" color="sky">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Pendapatan hari ini" color="emerald" :value="'Rp '.number_format($pendapatanHariIni, 0, ',', '.')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('petugas.transaksi.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Buka Transaksi Parkir
                </a>
            </div>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-900">Kendaraan Terbaru</h3>
                <div class="overflow-x-auto"><table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Plat nomor</th><th class="px-4 py-3">Area</th><th class="px-4 py-3">Waktu masuk</th><th class="px-4 py-3">Status</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transaksiTerbaru as $item)
                            <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 font-semibold">{{ $item->kendaraan?->plat_nomor ?? '—' }}</td><td class="px-4 py-3">{{ $item->area?->nama_area ?? '—' }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_masuk?->format('d/m/Y H:i') ?? '—' }}</td><td class="px-4 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $item->status === 'masuk' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">{{ ucfirst($item->status) }}</span></td></tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table></div>
            </section>
        </div>
    </div>
</x-app-layout>
