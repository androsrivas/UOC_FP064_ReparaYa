@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border rounded-custom shadow-sm-custom overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-border bg-bg/30">
            <h3 class="font-display text-lg text-text">{{ $title }}</h3>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-bg/50 border-t border-border">
            {{ $footer }}
        </div>
    @endif
</div>