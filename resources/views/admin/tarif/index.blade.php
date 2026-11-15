<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Admin</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Tarif Parkir</h2>
    </x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
        @include('admin.partials.flash')
        <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
            <div class="mb-5 flex justify-end">
                <a href="{{ route('admin.tarif.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Tarif
                </a>
            </div>
            <div class="overflow-x-auto"><table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Jenis kendaraan</th><th class="px-4 py-3 text-right">Tarif per jam</th><th class="px-4 py-3 text-right">Dipakai transaksi</th><th class="px-4 py-3 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse ($tarifList as $tarif)
                    <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3 font-semibold">{{ ucfirst($tarif->jenis_kendaraan) }}</td><td class="px-4 py-3 text-right font-medium text-emerald-700">Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</td><td class="px-4 py-3 text-right text-gray-600">{{ $tarif->transaksis_count }}</td><td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100 transition" href="{{ route('admin.tarif.edit', $tarif) }}">Edit</a><form method="POST" action="{{ route('admin.tarif.destroy', $tarif) }}" onsubmit="return confirm('Hapus tarif ini?')">@csrf @method('DELETE')<button class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100 transition">Hapus</button></form></div></td></tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada tarif.</td></tr>
                @endforelse
                </tbody>
            </table></div>
        </section>
    </div></div>
</x-app-layout>
