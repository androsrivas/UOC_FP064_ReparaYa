@props(['type' => 'info', 'message'])

@php
    $styles = [
        'info'    => 'bg-bg border-accent text-accent',
        'success' => 'bg-success-bg border-success text-success',
        'error'   => 'bg-error-bg border-error text-error',
        'warning' => 'bg-warning-bg border-warning text-warning',
    ];
@endphp

<div {{ $attributes->merge(['class' => "p-4 border-l-4 rounded-custom shadow-sm mb-4 " . $styles[$type]]) }} role="alert">
    <p class="text-sm font-medium">{{ $message ?? $slot }}</p>
</div>