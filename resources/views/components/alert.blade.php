@props(['type' => 'success', 'dismissible' => true])

@php
$styles = [
    'success' => ['wrap' => 'border-emerald-200 bg-emerald-50 text-emerald-800', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    'error'   => ['wrap' => 'border-rose-200 bg-rose-50 text-rose-800', 'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'],
];
$style = $styles[$type] ?? $styles['success'];
@endphp

<div {{ $attributes->merge(['class' => $style['wrap'].' mb-6 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm'] ) }}>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $style['icon'] }}" />
    </svg>
    <div class="min-w-0 flex-1">{{ $slot }}</div>
    @if ($dismissible)
        <button type="button" onclick="this.closest('div').remove()" class="ml-1 shrink-0 opacity-60 transition hover:opacity-100" aria-label="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
