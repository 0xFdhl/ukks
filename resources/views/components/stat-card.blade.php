@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'indigo',
])

@php
$palette = [
    'blue'    => ['tile' => 'bg-blue-100 text-blue-600', 'value' => 'text-gray-900'],
    'emerald' => ['tile' => 'bg-emerald-100 text-emerald-600', 'value' => 'text-emerald-700'],
    'amber'   => ['tile' => 'bg-amber-100 text-amber-600', 'value' => 'text-amber-700'],
    'sky'     => ['tile' => 'bg-sky-100 text-sky-600', 'value' => 'text-gray-900'],
    'violet'  => ['tile' => 'bg-violet-100 text-violet-600', 'value' => 'text-violet-700'],
    'rose'    => ['tile' => 'bg-rose-100 text-rose-600', 'value' => 'text-rose-700'],
];
$style = $palette[$color] ?? $palette['blue'];
@endphp

<article class="flex items-start gap-4 rounded-2xl bg-white p-5 ring-1 ring-gray-200/70 shadow-sm transition hover:shadow-md">
    @if ($icon)
        <div class="{{ $style['tile'] }} flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">
            {{ $icon }}
        </div>
    @endif
    <div class="min-w-0">
        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $label }}</p>
        <p class="mt-1.5 truncate text-2xl font-bold {{ $style['value'] }}">{{ $value }}</p>
        @isset($sub)
            <p class="mt-1 text-xs text-gray-500">{{ $sub }}</p>
        @endisset
    </div>
</article>
