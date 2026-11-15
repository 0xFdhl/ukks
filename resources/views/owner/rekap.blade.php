<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Owner</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Rekap Transaksi</h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <form method="GET" action="{{ route('owner.rekap') }}" class="grid gap-4 md:grid-cols-[1fr_1fr_auto] md:items-end">
                    <div><label for="tanggal_mulai" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal mulai</label><input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}" required class="w-full rounded-lg border-gray-300 shadow-sm"></div>
                    <div><label for="tanggal_selesai" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal selesai</label><input id="tanggal_selesai" type="date" name="tanggal_selesai" value="{{ $tanggalSelesai }}" required class="w-full rounded-lg border-gray-300 shadow-sm"></div>
                    <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">Tampilkan Rekap</button>
                </form>
                @error('tanggal_mulai')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                @error('tanggal_selesai')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </section>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-stat-card label="Jumlah transaksi selesai" :value="number_format($jumlahTransaksi)" color="sky">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>
                <x-stat-card label="Total pendapatan" color="emerald" :value="'Rp '.number_format($totalPendapatan, 0, ',', '.')">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </x-slot>
                </x-stat-card>
            </div>
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}</h3>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">{{ number_format($jumlahTransaksi) }} transaksi</span>
                </div>
                <div class="overflow-x-auto"><table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">No.</th><th class="px-4 py-3">Plat nomor</th><th class="px-4 py-3">Masuk</th><th class="px-4 py-3">Keluar</th><th class="px-4 py-3">Durasi</th><th class="px-4 py-3">Tarif/jam</th><th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3">Petugas</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transaksis as $item)
                            <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 text-gray-500">{{ $item->id }}</td><td class="px-4 py-3 font-semibold">{{ $item->kendaraan?->plat_nomor ?? '—' }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_masuk?->format('d/m/Y H:i') }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_keluar?->format('d/m/Y H:i') }}</td><td class="px-4 py-3">{{ $item->durasi_jam }} jam</td><td class="px-4 py-3">Rp {{ number_format($item->durasi_jam ? $item->biaya_total / $item->durasi_jam : $item->tarif->tarif_per_jam, 0, ',', '.') }}</td><td class="px-4 py-3 text-right font-medium text-emerald-700">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td><td class="px-4 py-3">{{ $item->user?->nama_lengkap ?? '—' }}</td></tr>
                        @empty
                            <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">Tidak ada transaksi pada rentang tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table></div>
                <div class="mt-4">{{ $transaksis->links() }}</div>
            </section>
        </div>
    </div>
</x-app-layout>
