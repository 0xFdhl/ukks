@if (session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif
@if (session('error'))
    <x-alert type="error">{{ session('error') }}</x-alert>
@endif
@if ($errors->any())
    <x-alert type="error">
        <p class="font-semibold mb-1">Periksa kembali data berikut:</p>
        <ul class="list-inside list-disc space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </x-alert>
@endif
