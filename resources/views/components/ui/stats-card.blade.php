@props(['title' => null, 'value' => null, 'color' => 'text-slate-800', 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border rounded-custom shadow-sm-custom overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-border bg-bg/30">
            <h3 class="font-display text-lg text-slate-700">{{ $title }}</h3>
        </div>
    @endif

    <div class="p-6">
        @if($value !== null)
            <div class="text-4xl font-bold {{ $color }}">
                {{ $value }}
            </div>
        @else
            {{ $slot }}
        @endif
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-bg/50 border-t border-border text-sm text-slate-500">
            {{ $footer }}
        </div>
    @endif
</div>