<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Admin</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Log Aktivitas</h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.flash')
            <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
                <form method="GET" action="{{ route('admin.log.index') }}" class="mb-5 grid gap-3 sm:grid-cols-[1fr_220px_auto]">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari aktivitas" class="rounded-lg border-gray-300 shadow-sm">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="rounded-lg border-gray-300 shadow-sm">
                    <button class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">Cari</button>
                </form>
                <div class="overflow-x-auto"><table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Waktu</th><th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Aktivitas</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($logs as $log)
                            <tr class="transition hover:bg-blue-50/40"><td class="whitespace-nowrap px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d/m/Y H:i:s') }}</td><td class="px-4 py-3 font-medium">{{ $log->user?->nama_lengkap ?? 'Akun tidak tersedia' }}</td><td class="px-4 py-3 text-gray-600">{{ $log->aktivitas }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-12 text-center text-gray-400">Belum ada log aktivitas.</td></tr>
                        @endforelse
                    </tbody>
                </table></div>
                <div class="mt-4">{{ $logs->links() }}</div>
            </section>
        </div>
    </div>
</x-app-layout>
