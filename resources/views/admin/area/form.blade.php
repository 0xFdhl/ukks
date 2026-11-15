<form method="POST" action="{{ $area->exists ? route('admin.area.update', $area) : route('admin.area.store') }}" class="space-y-5 rounded-xl bg-white p-6 shadow-sm">@csrf @if ($area->exists) @method('PUT') @endif
    @include('admin.partials.flash')
    <div><label for="nama_area" class="mb-1 block text-sm font-medium">Nama area</label><input id="nama_area" name="nama_area" value="{{ old('nama_area', $area->nama_area) }}" required maxlength="255" class="w-full rounded-md border-gray-300 shadow-sm">@error('nama_area')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
    <div><label for="kapasitas" class="mb-1 block text-sm font-medium">Kapasitas</label><input id="kapasitas" type="number" min="1" name="kapasitas" value="{{ old('kapasitas', $area->kapasitas) }}" required class="w-full rounded-md border-gray-300 shadow-sm">@error('kapasitas')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
    @if ($area->exists)<p class="text-sm text-gray-600">Terisi sekarang: <strong>{{ $area->terisi }}</strong> kendaraan. Jumlah ini dikelola oleh transaksi.</p>@endif
    <div class="flex justify-end gap-3"><a href="{{ route('admin.area.index') }}" class="rounded-md border px-4 py-2">Batal</a><button class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white">Simpan</button></div>
</form>
