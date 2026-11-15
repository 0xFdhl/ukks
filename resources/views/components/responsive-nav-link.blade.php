@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-s-4 border-blue-500 bg-blue-50 ps-3 pe-4 py-2 text-sm font-semibold text-blue-700 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full border-s-4 border-transparent ps-3 pe-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:outline-none focus:text-gray-800 focus:bg-gray-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
