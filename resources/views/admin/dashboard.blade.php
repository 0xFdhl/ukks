<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Admin</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-stat-card label="Kendaraan terdaftar" :value="number_format($jumlahKendaraan)" color="sky">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Sedang parkir" :value="number_format($transaksiAktif)" color="amber">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Kapasitas area terisi" color="violet" :value="number_format($areaTerisi).' / '.number_format($kapasitasArea)" sub="{{ $kapasitasArea > 0 ? round($areaTerisi / $kapasitasArea * 100) : 0 }}% dari total kapasitas">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card label="Pendapatan hari ini" color="emerald" :value="'Rp '.number_format($pendapatanHariIni, 0, ',', '.')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">{{ $transaksiTerbaru->count() }} transaksi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <th class="px-4 py-3">Plat nomor</th>
                                <th class="px-4 py-3">Area</th>
                                <th class="px-4 py-3">Waktu masuk</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transaksiTerbaru as $transaksi)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $transaksi->kendaraan?->plat_nomor ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $transaksi->area?->nama_area ?? '—' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $transaksi->waktu_masuk?->format('d/m/Y H:i') ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $transaksi->status === 'masuk' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ ucfirst($transaksi->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium">{{ $transaksi->biaya_total !== null ? 'Rp '.number_format($transaksi->biaya_total, 0, ',', '.') : '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
