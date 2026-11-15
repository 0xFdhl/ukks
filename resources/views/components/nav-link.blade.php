@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-600 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
