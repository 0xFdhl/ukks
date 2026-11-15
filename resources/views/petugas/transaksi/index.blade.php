<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Petugas</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Transaksi Parkir</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.flash')

            <!-- Catat masuk -->
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <div class="mb-5 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </span>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 leading-tight">Catat Kendaraan Masuk</h3>
                        <p class="text-xs text-gray-500">Pilih kendaraan dan area, lalu simpan untuk memulai parkir.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('petugas.transaksi.masuk') }}" class="grid gap-4 md:grid-cols-[2fr_2fr_1fr]">
                    @csrf
                    <div>
                        <label for="id_kendaraan" class="mb-1.5 block text-sm font-medium text-gray-700">Kendaraan</label>
                        <select id="id_kendaraan" name="id_kendaraan" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih kendaraan</option>
                            @foreach ($kendaraan as $item)
                                <option value="{{ $item->id }}" @selected(old('id_kendaraan') == $item->id)>{{ $item->plat_nomor }} — {{ ucfirst($item->jenis_kendaraan) }}{{ $item->pemilik ? ' · '.$item->pemilik : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_area" class="mb-1.5 block text-sm font-medium text-gray-700">Area parkir</label>
                        <select id="id_area" name="id_area" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih area</option>
                            @foreach ($area as $item)
                                <option value="{{ $item->id }}" @disabled($item->terisi >= $item->kapasitas) @selected(old('id_area') == $item->id)>{{ $item->nama_area }} ({{ $item->terisi }}/{{ $item->kapasitas }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 font-semibold text-white shadow-sm hover:bg-emerald-500 transition">Simpan Masuk</button>
                    </div>
                </form>
            </section>

            <!-- Sedang parkir -->
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 leading-tight">Kendaraan Sedang Parkir</h3>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ $transaksiAktif->count() }} aktif</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Plat nomor</th><th class="px-4 py-3">Jenis</th><th class="px-4 py-3">Area</th><th class="px-4 py-3">Waktu masuk</th><th class="px-4 py-3">Petugas</th><th class="px-4 py-3 text-right">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transaksiAktif as $item)
                                <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 font-semibold text-gray-900">{{ $item->kendaraan->plat_nomor }}</td><td class="px-4 py-3">{{ ucfirst($item->kendaraan->jenis_kendaraan) }}</td><td class="px-4 py-3">{{ $item->area->nama_area }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_masuk->format('d/m/Y H:i') }}</td><td class="px-4 py-3">{{ $item->user->nama_lengkap }}</td><td class="px-4 py-3 text-right"><form method="POST" action="{{ route('petugas.transaksi.keluar', $item->id) }}" onsubmit="return confirm('Proses kendaraan ini keluar sekarang?')">@csrf<button class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-500 transition">Proses Keluar</button></form></td></tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada kendaraan yang sedang parkir.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Riwayat -->
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-900">Riwayat Keluar Terbaru</h3>
                <div class="overflow-x-auto"><table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Plat nomor</th><th class="px-4 py-3">Keluar</th><th class="px-4 py-3">Durasi</th><th class="px-4 py-3 text-right">Biaya</th><th class="px-4 py-3">Struk</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($riwayat as $item)
                            <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 font-semibold">{{ $item->kendaraan->plat_nomor }}</td><td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $item->waktu_keluar?->format('d/m/Y H:i') }}</td><td class="px-4 py-3">{{ $item->durasi_jam }} jam</td><td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item->biaya_total, 0, ',', '.') }}</td><td class="px-4 py-3"><a class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100 transition" href="{{ route('petugas.struk', $item->id) }}">Lihat struk</a></td></tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table></div>
            </section>
        </div>
    </div>
</x-app-layout>
