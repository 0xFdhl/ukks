<x-app-layout>
    <x-slot name="header">
        <p class="text-sm font-medium text-blue-100">Admin</p>
        <h2 class="mt-0.5 text-2xl font-bold text-white">Manajemen User</h2>
    </x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        @include('admin.partials.flash')
        <section class="rounded-2xl bg-white p-6 ring-1 ring-gray-200/70 shadow-sm">
            <div class="mb-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <form method="GET" class="flex gap-2">
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama atau username" class="w-full rounded-lg border-gray-300 shadow-sm sm:w-72">
                    <button class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Cari</button>
                </form>
                <a href="{{ route('admin.user.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah User
                </a>
            </div>
            <div class="overflow-x-auto"><table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"><th class="px-4 py-3">Nama lengkap</th><th class="px-4 py-3">Username</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-blue-50/40"><td class="px-4 py-3">{{ $user->nama_lengkap }}</td><td class="px-4 py-3 font-medium text-gray-600">{{ $user->username }}</td><td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ ['admin' => 'bg-violet-100 text-violet-700', 'petugas' => 'bg-sky-100 text-sky-700', 'owner' => 'bg-emerald-100 text-emerald-700'][$user->role] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($user->role) }}</span></td><td class="px-4 py-3"><span class="inline-flex items-center gap-1.5 text-xs font-medium {{ $user->status_aktif ? 'text-emerald-600' : 'text-gray-400' }}"><span class="h-1.5 w-1.5 rounded-full {{ $user->status_aktif ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>{{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}</span></td><td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100 transition" href="{{ route('admin.user.edit', $user) }}">Edit</a><form method="POST" action="{{ route('admin.user.destroy', $user) }}" onsubmit="return confirm('Hapus akun {{ $user->username }}?')">@csrf @method('DELETE')<button class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100 transition">Hapus</button></form></div></td></tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada akun.</td></tr>
                    @endforelse
                </tbody>
            </table></div>
            <div class="mt-4">{{ $users->links() }}</div>
        </section>
    </div></div>
</x-app-layout>
