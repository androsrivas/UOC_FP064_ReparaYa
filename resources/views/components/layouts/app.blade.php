@php
    $rol = auth()->user()->rol;
    $config = config("ui.roles.{$rol}");
    $layoutType = $config['layout'] ?? 'sidebar';
    $theme = $config['theme'];
@endphp

<x-layouts.base :title="$title ?? 'ReparaYa'">
    <div class="min-h-screen {{ $theme['bg'] === 'bg-white' ? 'bg-slate-50' : $theme['bg'] }}">

        {{-- LAYOUT GESTORA --}}
        @if ($layoutType === 'top-nav')
            <header class="{{ $theme['bg'] }} {{ $theme['border'] }} border-b h-16 w-full fixed top-0 z-50">
                <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
                    <div class="flex items-center gap-8">
                        <span class="font-bold text-white text-xl tracking-tight">🔧 ReparaYa</span>
                        <nav class="flex gap-1">
                            @include('navigation.menus.' . $rol)
                        </nav>
                    </div>
                    <x-navigation.user-dropdown />
                </div>
            </header>
            <main class="pt-24 pb-12 max-w-7xl mx-auto px-6">
                {{ $slot }}
            </main>

        {{-- LAYOUT PARTICULAR --}}
        @elseif($layoutType === 'centered-app')
            <div class="flex justify-center bg-slate-100 min-h-screen">
                
                <div class="w-full max-w-md bg-white shadow-2xl flex flex-col min-h-screen relative">

                    
                    <header
                        class="p-6 border-b {{ $theme['border'] }} flex justify-between items-center sticky top-0 bg-white/80 backdrop-blur-md z-40">
                        <span class="font-black text-sky-600 text-2xl italic tracking-tighter">ReparaYa</span>
                        <x-navigation.user-dropdown />
                    </header>

                    <main class="flex-1 p-6 pb-32">
                        {{ $slot }}
                    </main>

                    <nav
                        class="fixed bottom-0 w-full max-w-md border-t {{ $theme['border'] }} bg-white/90 backdrop-blur-lg px-2 py-3 flex justify-around items-end z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.05)]">
                        @include('navigation.menus.' . $rol)
                    </nav>

                </div>
            </div>

            {{-- LAYOUT ADMIN / TÉCNIC --}}
        @else
            <div class="flex">
                <x-navigation.sidebar />

                <div class="flex-1 {{ str_replace('w-', 'ml-', $config['sidebar_width'] ?? 'w-64') }} transition-all duration-300">
                    <x-navigation.navbar />
                    <main class="p-8 lg:p-12">
                        <div class="max-w-6xl mx-auto">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        @endif

    </div>
</x-layouts.base>
