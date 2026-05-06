@props(['title' => 'Área de Cliente'])

<x-layouts.base :title="$title">
    <div class="flex min-h-screen flex-col bg-slate-50 font-sans">
        
        <x-navigation.navbar />

        @if (isset($header))
            <header class="bg-white border-b border-slate-200 shadow-sm">
                <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="grow w-full mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="animate-in fade-in duration-500">
                {{ $slot }}
            </div>
        </main>

        <x-navigation.footer />
        
    </div>
</x-layouts.base>