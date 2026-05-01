<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">

    <h2 class="text-lg font-semibold text-gray-700">
        {{ $title ?? 'Panel de administración' }}
    </h2>

    @auth
    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->nombre }}</p>
            <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->rol }}</p>
        </div>
        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
            {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
        </div>
    </div>
    @endauth

</header>