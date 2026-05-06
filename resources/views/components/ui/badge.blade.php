@props(['estado'])

@php
    $statusValue = strtolower($estado);

    $classes = match($statusValue) {
        'pendiente', 'abierta' => 'bg-orange-50 text-orange-700 border-orange-100',
        'en curso', 'proceso'  => 'bg-blue-50 text-blue-700 border-blue-100',
        'resuelta', 'cerrada'  => 'bg-teal-50 text-teal-700 border-teal-100',
        'cancelada'            => 'bg-slate-100 text-slate-600 border-slate-200',
        default                => 'bg-gray-50 text-gray-600 border-gray-100',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold $classes"]) }}>
    {{ ucfirst($estado) }}
</span>