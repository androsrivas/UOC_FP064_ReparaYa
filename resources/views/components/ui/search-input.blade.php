@props(['placeholder' => 'Buscar...', 'results' => []])

<div x-data="{ open: false }" @click.away="open = false" class="relative w-full">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-magnifying-glass text-slate-500"></i>
        </div>
        <input 
            {{ $attributes }}
            @focus="open = true"
            type="text"
            placeholder="{{ $placeholder }}"
            class="block w-full pl-10 pr-3 py-2 border border-slate-700 rounded-xl bg-slate-900 text-white placeholder-slate-500 focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm"
        >
    </div>

    <div x-show="open && @js(count($results) > 0)"
        x-transition
        class="absolute z-100 mt-2 w-full bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden">
        @foreach($results as $item)
            <button
                type="button"
                @click="open = false; $dispatch('selected', { id: {{ $item['id'] }}, name: '{{ $item['name'] }}' })"
                class="w-full text-left px-4 py-3 text-sm text-slate-200 hover:bg-cyan-600 hover:text-white transition-colors"
            >
                {{ $item['name'] }}
            </button>
        @endforeach

    </div>

</div>