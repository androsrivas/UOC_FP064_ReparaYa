@props(['variant' => 'primary', 'type' => 'button'])

@php
    $baseClasses = "inline-flex items-center justify-center px-5 py-2.5 rounded-custom font-body font-medium transition-custom focus:outline-none focus:ring-2 focus:ring-offset-2";
    
    $variants = [
        'primary'   => 'bg-accent text-white hover:bg-accent-hover focus:ring-accent',
        'secondary' => 'bg-surface border border-border text-text hover:bg-bg focus:ring-border',
        'danger'    => 'bg-error text-white hover:opacity-90 focus:ring-error',
        'ghost'     => 'text-muted hover:text-text hover:bg-bg',
    ];
@endphp

<button {{ $attributes->merge(['class' => $baseClasses . " " . $variants[$variant], 'type' => $type]) }}>
    {{ $slot }}
</button>